<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

/**
 * Creates the 9 classes (Grade 10/11/12 x A/B/C). Homeroom teacher
 * (`teacher_id`) is deliberately left unset here — ClassScheduleSeeder
 * assigns it after building each class's timetable, picking a homeroom
 * teacher from among the teachers who actually teach that class.
 */
class ClassSeeder extends Seeder
{
    public const CLASSES = [
        ['name' => 'Grade 10-A', 'track' => 'Science',        'grade_level' => '10'],
        ['name' => 'Grade 10-B', 'track' => 'Social Science', 'grade_level' => '10'],
        ['name' => 'Grade 10-C', 'track' => 'General',        'grade_level' => '10'],
        ['name' => 'Grade 11-A', 'track' => 'Science',        'grade_level' => '11'],
        ['name' => 'Grade 11-B', 'track' => 'Social Science', 'grade_level' => '11'],
        ['name' => 'Grade 11-C', 'track' => 'Arts',           'grade_level' => '11'],
        ['name' => 'Grade 12-A', 'track' => 'Science',        'grade_level' => '12'],
        ['name' => 'Grade 12-B', 'track' => 'Social Science', 'grade_level' => '12'],
        ['name' => 'Grade 12-C', 'track' => 'Commerce',       'grade_level' => '12'],
    ];

    public function run(): void
    {
        foreach (self::CLASSES as $data) {
            SchoolClass::firstOrCreate(
                ['name' => $data['name']],
                ['track' => $data['track'], 'grade_level' => $data['grade_level']]
            );
        }
    }
}
