<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Seeder;

/**
 * ~25 school days of attendance history per student, weekdays only (the
 * old version wastefully seeded weekend rows even though the school never
 * has class then).
 */
class AttendanceSeeder extends Seeder
{
    private const SCHOOL_DAYS_BACK = 25;

    public function run(): void
    {
        $students = Student::all();
        $statuses = ['present', 'present', 'present', 'present', 'present', 'late', 'absent'];

        foreach ($students as $student) {
            $date = now();
            $counted = 0;

            while ($counted < self::SCHOOL_DAYS_BACK) {
                $date = $date->copy()->subDay();

                if ($date->isWeekend()) {
                    continue;
                }

                Attendance::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id'   => $student->class_id,
                        'date'       => $date->toDateString(),
                    ],
                    ['status' => $statuses[array_rand($statuses)]]
                );

                $counted++;
            }
        }
    }
}
