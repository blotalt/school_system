<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\Concerns\GeneratesPeople;
use Illuminate\Database\Seeder;

/**
 * Creates every teacher the school employs. Deterministic and the SOLE
 * source of teachers — ClassScheduleSeeder no longer mints any on the fly.
 *
 * Each subject gets two teacher pools sized to the actual weekly demand
 * computed from SUBJECT_FREQUENCY (see ClassScheduleSeeder): a "morning"
 * batch created first, then an "afternoon" batch — ClassScheduleSeeder
 * recovers this split deterministically by querying teachers of a subject
 * ordered by id and slicing [0, morningCount) / [morningCount, total).
 */
class TeacherSeeder extends Seeder
{
    use GeneratesPeople;

    /**
     * [subject => [morningPoolSize, afternoonPoolSize]], sized to the
     * weekly demand of the 6 morning classes (Grade 10 A/B/C, 12 A/B/C)
     * and 3 afternoon classes (Grade 11 A/B/C) under SUBJECT_FREQUENCY.
     */
    public const SUBJECT_POOL_SIZES = [
        'Mathematics'        => [5, 3],
        'Khmer Literature'   => [5, 3],
        'English'            => [5, 3],
        'Physics'            => [2, 2],
        'Chemistry'          => [2, 2],
        'Biology'            => [2, 2],
        'Computer Science'   => [3, 2],
        'Earth Science'      => [2, 2],
        'History'            => [3, 2],
        'Geography'          => [3, 2],
        'Morality & Civics'  => [2, 2],
    ];

    public function run(): void
    {
        // Keep B1's original test teacher as a real, unassigned-homeroom teacher.
        $testUser = User::where('email', 'teacher@school.test')->first();
        if ($testUser && ! $testUser->teacher) {
            $teacher = Teacher::create([
                'user_id'           => $testUser->id,
                'subject_specialty' => 'Mathematics',
                'gender'            => 'male',
                'date_of_birth'     => '1985-01-01',
                'phone'             => '012-345-000',
            ]);
            $subject = Subject::where('name', 'Mathematics')->first();
            if ($subject) {
                $teacher->subjects()->syncWithoutDetaching([$subject->id]);
            }
        }

        $index = 0;

        foreach (self::SUBJECT_POOL_SIZES as $subjectName => [$morningCount, $afternoonCount]) {
            $subject = Subject::where('name', $subjectName)->first();
            if (! $subject) {
                continue;
            }

            $total = $morningCount + $afternoonCount;

            for ($i = 0; $i < $total; $i++) {
                $gender = $index % 2 === 0 ? 'male' : 'female';
                $person = $this->generatePerson($index, $gender);
                $email = $this->slugEmail($person['name'], 't', $index);
                $dob = sprintf('19%d-%02d-%02d', 70 + ($index % 25), 1 + ($index % 12), 1 + ($index % 28));
                $phone = sprintf('012-3%02d-%03d', $index % 100, ($index * 7) % 1000);

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name'       => $person['name'],
                        'khmer_name' => $person['khmer_name'],
                        'password'   => '123123123',
                        'role'       => 'teacher',
                    ]
                );

                if (! $user->wasRecentlyCreated) {
                    $user->update(['khmer_name' => $person['khmer_name']]);
                }

                if (! $user->teacher) {
                    $teacher = Teacher::create([
                        'user_id'           => $user->id,
                        'subject_specialty' => $subjectName,
                        'gender'            => $gender,
                        'date_of_birth'     => $dob,
                        'phone'             => $phone,
                    ]);

                    $teacher->subjects()->syncWithoutDetaching([$subject->id]);
                }

                $index++;
            }
        }
    }
}
