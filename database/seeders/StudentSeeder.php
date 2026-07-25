<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\Concerns\GeneratesPeople;
use Illuminate\Database\Seeder;

/**
 * Creates ~35 students per class across all 9 classes (~315 students),
 * deterministic Khmer names/genders, roll numbers sequential across the
 * whole school.
 */
class StudentSeeder extends Seeder
{
    use GeneratesPeople;

    private const STUDENTS_PER_CLASS = 35;

    public function run(): void
    {
        $classes = SchoolClass::orderBy('name')->get()->keyBy('name');

        $testStudent = User::where('email', 'student@school.test')->first();
        if ($testStudent && ! $testStudent->student) {
            $firstClass = $classes->first();
            Student::create([
                'user_id'  => $testStudent->id,
                'class_id' => $firstClass->id,
                'roll_no'  => 'STU-000',
                'gender'   => 'male',
            ]);
            $testStudent->update(['khmer_name' => 'សិស្ស​ ធ្វើ​តេស្ត']);
        }

        $roll = 1;
        $index = 0;

        foreach (ClassSeeder::CLASSES as $classData) {
            $class = $classes->get($classData['name']);
            if (! $class) {
                continue;
            }

            // Birth year scales with grade level for age-appropriate DOBs.
            $birthYear = 2016 - (int) $classData['grade_level'];

            for ($i = 0; $i < self::STUDENTS_PER_CLASS; $i++) {
                $gender = $index % 2 === 0 ? 'male' : 'female';
                $person = $this->generatePerson($index, $gender);
                $email = $this->slugEmail($person['name'], 's', $index);
                $dob = sprintf('%d-%02d-%02d', $birthYear, 1 + ($index % 12), 1 + ($index % 28));
                $guardianPhone = sprintf('012-1%02d-%03d', $index % 100, ($index * 3) % 1000);
                $rollNo = sprintf('STU-%03d', $roll);

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name'       => $person['name'],
                        'khmer_name' => $person['khmer_name'],
                        'password'   => '123123123',
                        'role'       => 'student',
                    ]
                );

                if (! $user->wasRecentlyCreated) {
                    $user->update(['khmer_name' => $person['khmer_name']]);
                }

                if (! $user->student) {
                    Student::create([
                        'user_id'          => $user->id,
                        'class_id'         => $class->id,
                        'roll_no'          => $rollNo,
                        'gender'           => $gender,
                        'date_of_birth'    => $dob,
                        'guardian_contact' => $guardianPhone,
                    ]);
                }

                $roll++;
                $index++;
            }
        }
    }
}
