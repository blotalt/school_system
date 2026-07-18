<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        // Author is an admin (fall back to any user if none seeded).
        $author = User::where('role', 'admin')->first() ?? User::first();

        if (! $author) {
            return;
        }

        Announcement::create([
            'author_id' => $author->id,
            'title'     => 'Mid-Term Exam Schedule Released',
            'body'      => 'The mid-term examination schedule for all grades has been published. Please check the Exams section for your specific timetable.',
            'audience'  => 'everyone',
            'priority'  => 'high',
        ]);

        Announcement::create([
            'author_id' => $author->id,
            'title'     => 'School Closed for Public Holiday',
            'body'      => 'The school will be closed on July 18th in observance of the public holiday. Classes will resume as normal the following day.',
            'audience'  => 'everyone',
            'priority'  => 'normal',
        ]);

        Announcement::create([
            'author_id' => $author->id,
            'title'     => 'Staff Meeting - Mandatory Attendance',
            'body'      => 'All teaching staff are required to attend the quarterly review meeting this Friday at 3:30 PM in Conference Room A.',
            'audience'  => 'teachers',
            'priority'  => 'medium',
        ]);

        // A class-specific announcement, if any class exists.
        if ($class = SchoolClass::first()) {
            Announcement::create([
                'author_id' => $author->id,
                'title'     => 'Homework Reminder for ' . $class->name,
                'body'      => 'Please remember to submit your assigned homework before the due date.',
                'audience'  => 'class',
                'class_id'  => $class->id,
                'priority'  => 'normal',
            ]);
        }
    }
}
