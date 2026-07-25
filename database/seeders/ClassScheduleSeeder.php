<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * Builds a complete, gap-free Monday-Friday timetable for every class: all
 * 4 periods x 5 days filled, in exactly one shift per class (no class ever
 * mixes morning/afternoon rows). Saturday is deliberately left untouched —
 * ScheduleRequestSeeder uses it for sample "request a Saturday session"
 * data, since the weekday grid ends up 100% full.
 *
 * Every teacher created by TeacherSeeder is guaranteed at least one slot
 * here (that's the whole point of TeacherSeeder's pool sizing) — nothing
 * in this seeder creates new teachers.
 */
class ClassScheduleSeeder extends Seeder
{
    private const WEEKDAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    private const PERIODS = [1, 2, 3, 4];
    private const SLOTS_PER_WEEK = 20; // 5 days x 4 periods

    /** Grade level => shift. */
    private const GRADE_SHIFT = ['10' => 'morning', '11' => 'afternoon', '12' => 'morning'];

    /** Track => [subject => weekly occurrences], each summing to 20. */
    private const SUBJECT_FREQUENCY = [
        'Science' => [
            'Mathematics' => 3, 'Khmer Literature' => 3, 'English' => 3,
            'Physics' => 2, 'Chemistry' => 2, 'Biology' => 2, 'Computer Science' => 2,
            'Earth Science' => 1, 'History' => 1, 'Geography' => 1,
        ],
        'Social Science' => [
            'Mathematics' => 3, 'Khmer Literature' => 3, 'English' => 3,
            'History' => 3, 'Geography' => 2, 'Morality & Civics' => 2,
            'Computer Science' => 1, 'Earth Science' => 1, 'Physics' => 1, 'Biology' => 1,
        ],
        'General' => [
            'Mathematics' => 3, 'Khmer Literature' => 3, 'English' => 3,
            'History' => 2, 'Geography' => 2, 'Computer Science' => 2,
            'Physics' => 1, 'Chemistry' => 1, 'Biology' => 1, 'Earth Science' => 1, 'Morality & Civics' => 1,
        ],
        'Arts' => [
            'Mathematics' => 3, 'Khmer Literature' => 3, 'English' => 3,
            'History' => 3, 'Geography' => 2, 'Computer Science' => 2,
            'Morality & Civics' => 1, 'Physics' => 1, 'Biology' => 1, 'Earth Science' => 1,
        ],
        'Commerce' => [
            'Mathematics' => 3, 'Khmer Literature' => 3, 'English' => 3,
            'Computer Science' => 3, 'Geography' => 2, 'History' => 2,
            'Earth Science' => 1, 'Morality & Civics' => 1, 'Physics' => 1, 'Biology' => 1,
        ],
    ];

    /** @var array<string,int> subject name => subject id, resolved once */
    private array $subjectIds = [];

    public function run(): void
    {
        $classes = SchoolClass::orderBy('name')->get();
        if ($classes->isEmpty()) {
            $this->command?->warn('ClassScheduleSeeder: no classes found, skipping.');
            return;
        }

        $this->subjectIds = Subject::pluck('id', 'name')->all();

        $classesByShift = $classes->groupBy(fn (SchoolClass $c) => self::GRADE_SHIFT[$c->grade_level] ?? 'morning');

        foreach ($classesByShift as $shift => $shiftClasses) {
            $this->scheduleShift($shift, $shiftClasses->values());
        }
    }

    private function scheduleShift(string $shift, Collection $shiftClasses): void
    {
        $teacherPools = []; // subject => Collection<Teacher>
        $pointer = [];      // subject => round-robin index into its pool
        $busy = [];         // "day-period" => [teacherId => true]

        $classCount = $shiftClasses->count();

        foreach ($shiftClasses as $classIndex => $class) {
            $frequency = self::SUBJECT_FREQUENCY[$class->track] ?? self::SUBJECT_FREQUENCY['General'];
            $sequence = $this->buildSequence($frequency);
            $offset = (int) round($classIndex * self::SLOTS_PER_WEEK / max($classCount, 1));
            $sequence = array_merge(array_slice($sequence, $offset), array_slice($sequence, 0, $offset));

            $teacherUsage = []; // teacherId => count, to pick a sensible homeroom teacher after

            $cell = 0;
            foreach (self::WEEKDAYS as $day) {
                foreach (self::PERIODS as $period) {
                    $subjectName = $sequence[$cell];
                    $cell++;

                    $teacherPools[$subjectName] ??= $this->teacherPoolFor($subjectName, $shift);
                    $slotKey = "{$day}-{$period}";
                    $busy[$slotKey] ??= [];

                    $teacherId = $this->pickFreeTeacher($teacherPools[$subjectName], $pointer, $subjectName, $busy[$slotKey], $shift, $day, $period);

                    ClassSchedule::create([
                        'class_id'    => $class->id,
                        'subject_id'  => $this->subjectIds[$subjectName],
                        'teacher_id'  => $teacherId,
                        'day_of_week' => $day,
                        'period'      => $period,
                        'shift'       => $shift,
                    ]);

                    $busy[$slotKey][$teacherId] = true;
                    $teacherUsage[$teacherId] = ($teacherUsage[$teacherId] ?? 0) + 1;
                }
            }

            arsort($teacherUsage);
            $homeroomTeacherId = array_key_first($teacherUsage);

            $class->update([
                'teacher_id'           => $homeroomTeacherId,
                'schedule_approved_at' => now(),
            ]);
        }
    }

    private function pickFreeTeacher(Collection $pool, array &$pointer, string $subjectName, array $busyAtSlot, string $shift, string $day, int $period): int
    {
        $size = $pool->count();
        $pointer[$subjectName] ??= 0;

        for ($tries = 0; $tries < $size; $tries++) {
            $candidate = $pool[($pointer[$subjectName] + $tries) % $size];
            if (empty($busyAtSlot[$candidate->id])) {
                $pointer[$subjectName] = ($pointer[$subjectName] + $tries + 1) % $size;

                return $candidate->id;
            }
        }

        // Extremely unlikely given pool sizing, but never crash: borrow any
        // teacher (any subject) free at this exact slot as a substitute.
        $busyTeacherIds = ClassSchedule::where('day_of_week', $day)
            ->where('period', $period)
            ->where('shift', $shift)
            ->pluck('teacher_id');

        $substituteId = Teacher::whereNotIn('id', $busyTeacherIds)->value('id');

        if (! $substituteId) {
            throw new \RuntimeException("No teacher available at all for {$day} period {$period} ({$shift}).");
        }

        return $substituteId;
    }

    /**
     * Splits every teacher of this subject between the two shifts,
     * proportional to the target [morning, afternoon] sizing but scaled to
     * consume the full available set — self-correcting if the actual
     * headcount differs slightly from the target (e.g. the pre-existing
     * test teacher adding one extra Mathematics teacher), so nobody is
     * ever left unused.
     */
    private function teacherPoolFor(string $subjectName, string $shift): Collection
    {
        [$morningTarget, $afternoonTarget] = TeacherSeeder::SUBJECT_POOL_SIZES[$subjectName] ?? [2, 2];

        $ordered = Teacher::whereHas('subjects', fn ($q) => $q->where('subjects.name', $subjectName))
            ->orderBy('id')
            ->get();

        $total = $ordered->count();
        if ($total === 0) {
            return collect();
        }

        $morningShare = (int) round($total * $morningTarget / max($morningTarget + $afternoonTarget, 1));
        // Keep both shares non-empty (pool sizing always targets >=2 per shift, so total is always >=4).
        $morningShare = max(1, min($morningShare, $total - 1));

        return $shift === 'morning'
            ? $ordered->slice(0, $morningShare)->values()
            : $ordered->slice($morningShare)->values();
    }

    /**
     * Evenly spread each subject's weekly occurrences across 20 slots
     * (largest-remainder-style placement) so the same subject never
     * clusters together within a week.
     *
     * @param array<string,int> $frequency
     * @return string[] length-20 ordered subject names
     */
    private function buildSequence(array $frequency): array
    {
        $entries = [];

        foreach ($frequency as $subject => $count) {
            for ($j = 0; $j < $count; $j++) {
                $position = ($j + 0.5) * (self::SLOTS_PER_WEEK / $count);
                $entries[] = [$position, $subject];
            }
        }

        usort($entries, fn ($a, $b) => $a[0] <=> $b[0]);

        return array_map(fn ($e) => $e[1], $entries);
    }
}
