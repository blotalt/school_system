<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Concerns\ExportsTables;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ExamResult;

class GradeController extends Controller
{
    use ExportsTables;

    private const GRADE_HEADERS = ['Subject', 'Exam', 'Score', 'Max Score', 'Grade'];

    public function index()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return view('student.grades', [
                'student' => null, 'class' => null, 'results' => collect(),
                'attendanceRate' => 0, 'averageScore' => null,
            ]);
        }

        $class = $student->schoolClass()->with('teacher.user')->first();

        // Self-scoped: only ever fetch THIS student's results. Never leaves the DB otherwise.
        $results = ExamResult::where('student_id', $student->id)
            ->with('exam.subject')
            ->latest()
            ->get();

        $percentages = $results->map(fn (ExamResult $r) => $r->exam->max_score > 0
            ? $r->score / $r->exam->max_score * 100
            : null)->filter();
        $averageScore = $percentages->isNotEmpty() ? round($percentages->avg(), 1) : null;

        $total   = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendanceRate = $total > 0 ? round($present / $total * 100, 1) : 0;

        return view('student.grades', compact('student', 'class', 'results', 'attendanceRate', 'averageScore'));
    }

    public function exportGradesCsv()
    {
        return $this->exportCsv('my-grades.csv', self::GRADE_HEADERS, $this->gradeRows());
    }

    public function exportGradesPdf()
    {
        return $this->exportPdf('my-grades.pdf', 'My Grades', self::GRADE_HEADERS, $this->gradeRows());
    }

    // Self-scoped: only ever builds rows from THIS student's own results.
    private function gradeRows()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return collect();
        }

        $results = ExamResult::where('student_id', $student->id)
            ->with('exam.subject')
            ->latest()
            ->get();

        return $results->map(function (ExamResult $result) {
            $pct = $result->exam->max_score > 0 ? $result->score / $result->exam->max_score * 100 : null;
            $grade = match (true) {
                $pct === null => '',
                $pct >= 90 => 'A', $pct >= 80 => 'B', $pct >= 70 => 'C', $pct >= 60 => 'D',
                default => 'F',
            };

            return [
                $result->exam->subject->name ?? '',
                $result->exam->title,
                $result->score,
                $result->exam->max_score,
                $grade,
            ];
        });
    }
}
