<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassScheduleSeeder extends Seeder
{
    private const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    private const PERIODS = [1, 2, 3, 4];
    private const SHIFT = 'morning';

    private array $firstNames = [
        'Sophea', 'Dara', 'Chanthy', 'Vichea', 'Sreymom', 'Pisey', 'Rithy', 'Kunthea',
        'Bopha', 'Chandara', 'Sovann', 'Malis', 'Ratanak', 'Sokha', 'Vanna', 'Chenda',
        'Phirun', 'Kanya', 'Sarun', 'Mealea',
    ];

    private array $lastNames = [
        'Chan', 'Sok', 'Meas', 'Heng', 'Tan', 'Prak', 'Ly', 'Sar', 'Nguon', 'Chea',
    ];

    /**
     * Gives every class every subject, one weekly slot each, taught by a
     * teacher who specializes in only that subject. Each subject gets 2-5
     * teachers who randomly split the classes between them. Slot picking
     * avoids double-booking the class OR the teacher for that day/period.
     */
    public function run(): void
    {
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        if ($classes->isEmpty() || $subjects->isEmpty()) {
            $this->command?->warn('No classes or subjects found — nothing to schedule.');

            return;
        }

        $classSlotsUsed = [];   // [class_id]['Day-Period'] => true
        $teacherSlotsUsed = []; // [teacher_id]['Day-Period'] => true
        $nameIndex = 0;

        foreach ($subjects as $subject) {
            $teacherCount = min($classes->count(), random_int(2, 5));

            // Reuse teachers who already specialize in this subject before
            // creating new ones, so real teachers (e.g. from TeacherSeeder)
            // aren't duplicated by fresh randomly-generated ones.
            $teachers = Teacher::whereHas('subjects', fn ($q) => $q->where('subjects.id', $subject->id))->get();

            while ($teachers->count() < $teacherCount) {
                $teachers->push($this->makeTeacher($subject, $nameIndex++));
            }

            // Randomly split all classes among this subject's teachers —
            // every teacher gets at least one, coverage is guaranteed.
            $shuffledClasses = $classes->shuffle()->values();
            $shuffledTeachers = $teachers->shuffle()->values();

            foreach ($shuffledClasses as $index => $class) {
                $teacher = $shuffledTeachers[$index % $shuffledTeachers->count()];

                $slot = $this->findFreeSlot($class->id, $teacher->id, $classSlotsUsed, $teacherSlotsUsed);

                ClassSchedule::create([
                    'class_id'    => $class->id,
                    'subject_id'  => $subject->id,
                    'teacher_id'  => $teacher->id,
                    'day_of_week' => $slot['day'],
                    'period'      => $slot['period'],
                    'shift'       => self::SHIFT,
                ]);

                $classSlotsUsed[$class->id][$slot['key']] = true;
                $teacherSlotsUsed[$teacher->id][$slot['key']] = true;
            }
        }
    }

    private function makeTeacher(Subject $subject, int $index): Teacher
    {
        $name = $this->firstNames[$index % count($this->firstNames)]
            . ' ' . $this->lastNames[intdiv($index, count($this->firstNames)) % count($this->lastNames)];

        $email = 'teacher.' . $subject->id . '.' . $index . '@school.test';

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => 'password',
            'role'     => 'teacher',
        ]);

        $teacher = Teacher::create([
            'user_id'           => $user->id,
            'subject_specialty' => $subject->name,
        ]);

        $teacher->subjects()->attach($subject->id);

        return $teacher;
    }

    private function findFreeSlot(int $classId, int $teacherId, array &$classUsed, array &$teacherUsed): array
    {
        $combos = [];
        foreach (self::DAYS as $day) {
            foreach (self::PERIODS as $period) {
                $combos[] = ['day' => $day, 'period' => $period, 'key' => "{$day}-{$period}"];
            }
        }
        shuffle($combos);

        foreach ($combos as $combo) {
            $classFree = empty($classUsed[$classId][$combo['key']]);
            $teacherFree = empty($teacherUsed[$teacherId][$combo['key']]);

            if ($classFree && $teacherFree) {
                return $combo;
            }
        }

        throw new \RuntimeException("No free schedule slot for class {$classId} / teacher {$teacherId}.");
    }
}
