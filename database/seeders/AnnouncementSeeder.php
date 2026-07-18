<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@school.test')->first();

        $announcements = [
            [
                'title'    => 'Mid-Term Exam Schedule Released',
                'body'     => 'The mid-term examination schedule for all grades has been published. Please check the Exams section for your specific timetable.',
                'audience' => 'students',
            ],
            [
                'title'    => 'School Closed for Public Holiday',
                'body'     => 'The school will be closed on July 18th in observance of the public holiday. Classes will resume as normal the following day.',
                'audience' => 'all',
            ],
            [
                'title'    => 'Staff Meeting - Mandatory Attendance',
                'body'     => 'All teaching staff are required to attend the quarterly review meeting this Friday at 3:30 PM in Conference Room A.',
                'audience' => 'teachers',
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::firstOrCreate(
                ['title' => $data['title']],
                [
                    'author_id' => $admin->id,
                    'body'      => $data['body'],
                    'audience'  => $data['audience'],
                ]
            );
        }
    }
}
