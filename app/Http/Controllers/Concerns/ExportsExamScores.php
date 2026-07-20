<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsExamScores
{
    protected function exportExamScoresCsv(Exam $exam): StreamedResponse
    {
        $exam->loadMissing(['schoolClass', 'subject']);

        $students = Student::with('user')
            ->where('class_id', $exam->class_id)
            ->orderBy('roll_no')
            ->get();

        $scores = ExamResult::where('exam_id', $exam->id)->pluck('score', 'student_id');

        $filename = str($exam->title . '-scores')->slug() . '.csv';

        return response()->streamDownload(function () use ($students, $scores, $exam) {
            $out = fopen('php://output', 'w');
            // Excel needs a UTF-8 BOM to render non-ASCII names correctly.
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Student Name', 'Roll No', 'Subject', 'Score', 'Max Score', 'Grade']);

            foreach ($students as $student) {
                fputcsv($out, $this->examScoreRow($student, $scores->get($student->id), $exam));
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function examScoreRow(Student $student, ?int $score, Exam $exam): array
    {
        $pct = $score !== null && $exam->max_score > 0 ? $score / $exam->max_score * 100 : null;
        $grade = match (true) {
            $pct === null => '',
            $pct >= 90 => 'A', $pct >= 80 => 'B', $pct >= 70 => 'C', $pct >= 60 => 'D',
            default => 'F',
        };

        return [
            $student->user->name,
            $student->roll_no,
            $exam->subject->name ?? '',
            $score ?? '',
            $exam->max_score,
            $grade,
        ];
    }
}
