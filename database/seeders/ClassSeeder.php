<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name' => 'Grade 10-A', 'track' => 'Science',       'grade_level' => '10', 'homeroom_email' => 'chan.prak@school.test'],
            ['name' => 'Grade 10-B', 'track' => 'Arts',          'grade_level' => '10', 'homeroom_email' => 'samnang.sok@school.test'],
            ['name' => 'Grade 11-A', 'track' => 'Science',       'grade_level' => '11', 'homeroom_email' => 'rattana.nguon@school.test'],
            ['name' => 'Grade 11-B', 'track' => 'Commerce',      'grade_level' => '11', 'homeroom_email' => 'thida.meas@school.test'],
        ];

        foreach ($classes as $data) {
            $teacher = null;
            $user = User::where('email', $data['homeroom_email'])->first();
            if ($user) {
                $teacher = $user->teacher;
            }

            SchoolClass::firstOrCreate(
                ['name' => $data['name']],
                [
                    'track'       => $data['track'],
                    'grade_level' => $data['grade_level'],
                    'teacher_id'  => $teacher?->id,
                ]
            );
        }
    }
}
