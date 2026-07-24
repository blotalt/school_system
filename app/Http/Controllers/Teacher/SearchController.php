<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Exam;
use App\Models\Homework;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $teacher = $request->user()->teacher;

        if (mb_strlen($query) < 2 || ! $teacher) {
            return response()->json(['results' => []]);
        }

        $classIds = $this->connectedClassIds($teacher->id);

        $results = [];

        $classes = SchoolClass::whereIn('id', $classIds)
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($classes->isNotEmpty()) {
            $results['Classes'] = $classes->map(fn (SchoolClass $c) => [
                'title'    => $c->name,
                'subtitle' => $c->track ?? 'General',
                'url'      => route('teacher.schedule.index', ['class' => $c->id]),
            ]);
        }

        $students = Student::with('user')
            ->whereIn('class_id', $classIds)
            ->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$query}%"))
            ->limit(5)
            ->get();

        if ($students->isNotEmpty()) {
            $results['Students'] = $students->map(fn (Student $s) => [
                'title'    => $s->user->name,
                'subtitle' => $s->roll_no,
                'url'      => route('teacher.attendance.show', $s->class_id),
            ]);
        }

        $homeworks = Homework::where('teacher_id', $teacher->id)
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($homeworks->isNotEmpty()) {
            $results['Homework'] = $homeworks->map(fn (Homework $h) => [
                'title'    => $h->title,
                'subtitle' => $h->schoolClass->name ?? '',
                'url'      => route('teacher.homework.edit', $h),
            ]);
        }

        $exams = Exam::with('schoolClass')
            ->where('teacher_id', $teacher->id)
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($exams->isNotEmpty()) {
            $results['Exams'] = $exams->map(fn (Exam $e) => [
                'title'    => $e->title,
                'subtitle' => $e->schoolClass->name ?? '',
                'url'      => route('teacher.gradebook.show', $e),
            ]);
        }

        return response()->json(['results' => $results]);
    }

    /**
     * Classes this teacher is actually connected to: their homeroom
     * class(es), plus any class where they teach at least one period.
     */
    private function connectedClassIds(int $teacherId)
    {
        $taughtClassIds = ClassSchedule::where('teacher_id', $teacherId)->pluck('class_id');
        $homeroomClassIds = SchoolClass::where('teacher_id', $teacherId)->pluck('id');

        return $homeroomClassIds->merge($taughtClassIds)->unique();
    }
}
