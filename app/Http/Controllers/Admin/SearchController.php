<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q'));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        $students = Student::with('user')
            ->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$query}%"))
            ->orWhere('roll_no', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($students->isNotEmpty()) {
            $results['Students'] = $students->map(fn (Student $s) => [
                'title'    => $s->user->name,
                'subtitle' => $s->roll_no,
                'url'      => route('admin.students.edit', $s),
            ]);
        }

        $teachers = Teacher::with('user')
            ->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$query}%")->orWhere('email', 'like', "%{$query}%"))
            ->limit(5)
            ->get();

        if ($teachers->isNotEmpty()) {
            $results['Teachers'] = $teachers->map(fn (Teacher $t) => [
                'title'    => $t->user->name,
                'subtitle' => $t->user->email,
                'url'      => route('admin.teachers.edit', $t),
            ]);
        }

        $classes = SchoolClass::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($classes->isNotEmpty()) {
            $results['Classes'] = $classes->map(fn (SchoolClass $c) => [
                'title'    => $c->name,
                'subtitle' => $c->track ?? 'General',
                'url'      => route('admin.classes.index', ['class' => $c->id]),
            ]);
        }

        $exams = Exam::with('schoolClass')
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($exams->isNotEmpty()) {
            $results['Exams'] = $exams->map(fn (Exam $e) => [
                'title'    => $e->title,
                'subtitle' => $e->schoolClass->name ?? '',
                'url'      => route('admin.exams.results.index', $e),
            ]);
        }

        return response()->json(['results' => $results]);
    }
}
