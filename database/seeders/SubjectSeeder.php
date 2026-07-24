<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'Mathematics',
            'Physics',
            'Biology',
            'Chemistry',
            'English',
            'History',
            'Geography',
            'Computer Science',
            'Khmer Literature',
            'Earth Science',
            'Morality & Civics',
        ];

        foreach ($subjects as $name) {
            Subject::firstOrCreate(['name' => $name]);
        }
    }
}
