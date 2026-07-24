<?php

namespace App\Http\Controllers\Concerns;

use App\Models\SchoolClass;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsAttendance
{
    use ExportsTables;

    private const ATTENDANCE_HEADERS = ['Student Name', 'Roll No', 'Date', 'Status'];

    protected function exportAttendanceCsv(SchoolClass $class, string $date, Collection $students, array $statusByStudentId): StreamedResponse
    {
        $filename = str($class->name . '-attendance-' . $date)->slug() . '.csv';

        return $this->exportCsv($filename, self::ATTENDANCE_HEADERS, $this->attendanceRows($students, $statusByStudentId, $date));
    }

    protected function exportAttendancePdf(SchoolClass $class, string $date, Collection $students, array $statusByStudentId): Response
    {
        $filename = str($class->name . '-attendance-' . $date)->slug() . '.pdf';
        $title = $class->name . ' - Attendance - ' . $date;

        return $this->exportPdf($filename, $title, self::ATTENDANCE_HEADERS, $this->attendanceRows($students, $statusByStudentId, $date));
    }

    private function attendanceRows(Collection $students, array $statusByStudentId, string $date): Collection
    {
        return $students->map(fn ($student) => [
            $student->user->name,
            $student->roll_no,
            $date,
            ucfirst($statusByStudentId[$student->id] ?? 'unmarked'),
        ]);
    }
}
