<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Exam;
use App\Models\Homework;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $student = $request->user()->student;

        if (mb_strlen($query) < 2 || ! $student) {
            return response()->json(['results' => []]);
        }

        $results = [];

        $homeworks = Homework::with('subject')
            ->where('class_id', $student->class_id)
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($homeworks->isNotEmpty()) {
            $results['Homework'] = $homeworks->map(fn (Homework $h) => [
                'title'    => $h->title,
                'subtitle' => $h->subject->name ?? '',
                'url'      => route('student.view-task', $h),
            ]);
        }

        $exams = Exam::with('subject')
            ->where('class_id', $student->class_id)
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($exams->isNotEmpty()) {
            $results['Exams'] = $exams->map(fn (Exam $e) => [
                'title'    => $e->title,
                'subtitle' => $e->subject->name ?? '',
                'url'      => route('student.schedule.index'),
            ]);
        }

        $announcements = Announcement::visibleToStudent($student->class_id)
            ->where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        if ($announcements->isNotEmpty()) {
            $results['Announcements'] = $announcements->map(fn (Announcement $a) => [
                'title'    => $a->title,
                'subtitle' => $a->created_at->format('M j, Y'),
                'url'      => route('student.announcements'),
            ]);
        }

        return response()->json(['results' => $results]);
    }
}
