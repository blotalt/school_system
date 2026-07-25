<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsExamScores
{
    use ExportsTables;

    private const SCORE_HEADERS = ['Student Name', 'Roll No', 'Subject', 'Score', 'Max Score', 'Grade'];

    protected function exportExamScoresCsv(Exam $exam): StreamedResponse
    {
        [$filename, $rows] = $this->examScoreExportData($exam, 'csv');

        return $this->exportCsv($filename, self::SCORE_HEADERS, $rows);
    }

    protected function exportExamScoresPdf(Exam $exam): Response
    {
        [$filename, $rows] = $this->examScoreExportData($exam, 'pdf');

        return $this->exportPdf($filename, $exam->title . ' - Scores', self::SCORE_HEADERS, $rows);
    }

    private function examScoreExportData(Exam $exam, string $extension): array
    {
        $exam->loadMissing(['schoolClass', 'subject']);

        $students = Student::with('user')
            ->where('class_id', $exam->class_id)
            ->orderBy('roll_no')
            ->get();

        $scores = ExamResult::where('exam_id', $exam->id)->pluck('score', 'student_id');

        $filename = str($exam->title . '-scores')->slug() . '.' . $extension;

        $rows = $students->map(
            fn (Student $student) => $this->examScoreRow($student, $scores->get($student->id), $exam)
        );

        return [$filename, $rows];
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
