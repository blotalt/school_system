<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\Teacher;
use App\Models\TeacherAvailability;
use Illuminate\Database\Seeder;

/**
 * Seeds a realistic (not exhaustive) subset of each teacher's self-reported
 * availability: their actual teaching slots as "preferred", plus a few
 * extra open slots in their own shift as "available". Slots left untouched
 * correctly render as "No data" in the admin grid — a full 24-row matrix
 * per teacher isn't needed.
 */
class TeacherAvailabilitySeeder extends Seeder
{
    private const WEEKDAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    private const PERIODS = [1, 2, 3, 4];

    public function run(): void
    {
        $teachers = Teacher::all();

        foreach ($teachers as $index => $teacher) {
            $rows = ClassSchedule::where('teacher_id', $teacher->id)->get(['day_of_week', 'period', 'shift']);

            if ($rows->isEmpty()) {
                continue;
            }

            $shift = $rows->first()->shift;
            $taken = $rows->map(fn ($r) => "{$r->day_of_week}-{$r->period}")->all();

            foreach ($rows as $row) {
                TeacherAvailability::updateOrCreate(
                    ['teacher_id' => $teacher->id, 'day_of_week' => $row->day_of_week, 'period' => $row->period, 'shift' => $shift],
                    ['status' => 'preferred']
                );
            }

            // A few extra open slots in the same shift, deterministically chosen.
            $open = [];
            foreach (self::WEEKDAYS as $day) {
                foreach (self::PERIODS as $period) {
                    $key = "{$day}-{$period}";
                    if (! in_array($key, $taken, true)) {
                        $open[] = [$day, $period];
                    }
                }
            }

            $extraCount = min(3, count($open));
            for ($i = 0; $i < $extraCount; $i++) {
                [$day, $period] = $open[($index * 3 + $i) % count($open)];
                TeacherAvailability::updateOrCreate(
                    ['teacher_id' => $teacher->id, 'day_of_week' => $day, 'period' => $period, 'shift' => $shift],
                    ['status' => 'available']
                );
            }
        }
    }
}
