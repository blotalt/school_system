<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            return;
        }

        $statuses = ['present', 'present', 'present', 'late', 'absent'];

        foreach ($students as $student) {
            foreach (range(0, 6) as $daysAgo) {
                $date = now()->subDays($daysAgo)->toDateString();

                Attendance::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id'   => $student->class_id,
                        'date'       => $date,
                    ],
                    [
                        'status' => $statuses[array_rand($statuses)],
                    ]
                );
            }
        }
    }
}
