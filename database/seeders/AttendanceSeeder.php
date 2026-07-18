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
        $statuses = ['present', 'present', 'present', 'present', 'late', 'absent'];

        foreach ($students as $student) {
            for ($day = 1; $day <= 10; $day++) {
                $date = now()->subDays($day)->toDateString();

                Attendance::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id'   => $student->class_id,
                        'date'       => $date,
                    ],
                    ['status' => $statuses[array_rand($statuses)]]
                );
            }
        }
    }
}
