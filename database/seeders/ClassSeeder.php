<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();

        $classes = [
            ['name' => 'Grade 10-A', 'track' => 'Science',  'grade_level' => '10'],
            ['name' => 'Grade 10-B', 'track' => 'Arts',     'grade_level' => '10'],
            ['name' => 'Grade 11-A', 'track' => 'Science',  'grade_level' => '11'],
            ['name' => 'Grade 11-B', 'track' => 'Commerce', 'grade_level' => '11'],
        ];

        foreach ($classes as $i => $data) {
            SchoolClass::firstOrCreate(
                ['name' => $data['name']],
                [
                    'track'       => $data['track'],
                    'grade_level' => $data['grade_level'],
                    'teacher_id'  => $teachers->get($i % $teachers->count())?->id,
                ]
            );
        }
    }
}
