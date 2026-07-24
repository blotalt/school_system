<?php

namespace App\Support;

use App\Models\ClassSchedule;

class Timetable
{
    public const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    public const PERIOD_TIMES = [
        'morning' => [
            1 => '7:10 - 8:00',
            2 => '8:10 - 9:00',
            3 => '9:10 - 10:00',
            4 => '10:10 - 11:00',
        ],
        'afternoon' => [
            1 => '1:10 - 2:00',
            2 => '2:10 - 3:00',
            3 => '3:10 - 4:00',
            4 => '4:10 - 5:00',
        ],
    ];

    /**
     * The other live class_schedules row (if any) that would conflict with
     * placing this teacher in the given slot for a different class.
     */
    public static function teacherConflict(int $teacherId, string $dayOfWeek, int $period, string $shift, int $excludeClassId): ?ClassSchedule
    {
        return ClassSchedule::with(['teacher.user', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->where('day_of_week', $dayOfWeek)
            ->where('period', $period)
            ->where('shift', $shift)
            ->where('class_id', '!=', $excludeClassId)
            ->first();
    }
}
