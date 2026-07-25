<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * A realistic mixed-language notice board: some announcements are written
 * entirely in Khmer, some in English (there's no dual-language column on
 * `announcements` like `users.khmer_name`, and the teacher/student views
 * still render `body` as escaped plain text, so genuine HTML/locale-switch
 * content would either break rendering or only work in one portal).
 */
class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('role', 'admin')->first() ?? User::first();
        if (! $author) {
            return;
        }

        $classes = SchoolClass::orderBy('name')->get();
        $classA = $classes->get(0);
        $classB = $classes->get(4);

        $announcements = [
            ['title' => 'Mid-Term Exam Schedule Released', 'body' => 'The mid-term examination schedule for all grades has been published. Please check the Exams section for your specific timetable.', 'audience' => 'everyone', 'priority' => 'high', 'days_ago' => 1],
            ['title' => 'សាលារៀនបិទថ្ងៃបុណ្យជាតិ', 'body' => 'សាលារៀននឹងបិទនៅថ្ងៃទី១៨ ខែកក្កដា ដើម្បីអបអរសាទរថ្ងៃបុណ្យជាតិ។ ការសិក្សានឹងបន្តធម្មតាវិញនៅថ្ងៃបន្ទាប់។', 'audience' => 'everyone', 'priority' => 'normal', 'days_ago' => 3],
            ['title' => 'Staff Meeting - Mandatory Attendance', 'body' => 'All teaching staff are required to attend the quarterly review meeting this Friday at 3:30 PM in the main conference room.', 'audience' => 'teachers', 'priority' => 'medium', 'days_ago' => 2],
            ['title' => 'ការប្រជុំគ្រូបង្រៀនប្រចាំខែ', 'body' => 'សូមគ្រូបង្រៀនទាំងអស់អញ្ជើញចូលរួមប្រជុំប្រចាំខែនៅថ្ងៃពុធ ម៉ោង ៣ រសៀល ដើម្បីពិភាក្សាអំពីវឌ្ឍនភាពសិស្ស។', 'audience' => 'teachers', 'priority' => 'normal', 'days_ago' => 8],
            ['title' => 'Final Exam Preparation Tips', 'body' => "As final exams approach, make sure to review your notes regularly and get enough rest. Ask your subject teachers if you need extra help.", 'audience' => 'students', 'priority' => 'high', 'days_ago' => 4],
            ['title' => 'ម៉ោងបើកបណ្ណាល័យ', 'body' => 'បណ្ណាល័យសាលាបើកពីម៉ោង ៧ ព្រឹក ដល់ម៉ោង ៥ល្ងាច ចាប់ពីថ្ងៃច័ន្ទ ដល់ថ្ងៃសុក្រ។ សិស្សអាចមកសិក្សា និងខ្ចីសៀវភៅបាន។', 'audience' => 'students', 'priority' => 'normal', 'days_ago' => 10],
            ['title' => 'Homework Reminder for ' . ($classA?->name ?? 'Grade 10-A'), 'body' => 'Please remember to submit your assigned homework before the due date. Late submissions will affect your grade.', 'audience' => 'class', 'class_id' => $classA?->id, 'priority' => 'normal', 'days_ago' => 1],
            ['title' => 'សេចក្ដីជូនដំណឹងសម្រាប់ ' . ($classB?->name ?? 'Grade 11-B'), 'body' => 'សូមសិស្សថ្នាក់នេះត្រៀមខ្លួនសម្រាប់ការប្រឡងខែនេះ។ កាលវិភាគលម្អិតអាចរកមើលបាននៅផ្នែកការប្រឡង។', 'audience' => 'class', 'class_id' => $classB?->id, 'priority' => 'high', 'days_ago' => 6],
            ['title' => 'Annual Sports Day Announcement', 'body' => 'Our annual sports day will be held next month. All students are encouraged to sign up for at least one event with their homeroom teacher.', 'audience' => 'everyone', 'priority' => 'normal', 'days_ago' => 12],
            ['title' => 'សន្និសីទឪពុកម្តាយ-គ្រូបង្រៀន', 'body' => 'សាលាសូមអញ្ជើញឪពុកម្តាយអភិវឌ្ឍចូលរួមកិច្ចប្រជុំពិភាក្សាអំពីលទ្ធផលសិក្សារបស់កូនៗ នៅចុងសប្តាហ៍នេះ។', 'audience' => 'everyone', 'priority' => 'high', 'days_ago' => 5],
            ['title' => 'Grade Submission Deadline', 'body' => 'All teachers must submit monthly exam grades through the gradebook by the end of this week. Contact the admin office with any issues.', 'audience' => 'teachers', 'priority' => 'normal', 'days_ago' => 15],
            ['title' => 'ការប្រកួតកីឡាអន្តរសាលា', 'body' => 'សិស្សដែលចាប់អារម្មណ៍ចូលរួមការប្រកួតកីឡាអន្តរសាលា សូមចុះឈ្មោះជាមួយគ្រូបង្គោលថ្នាក់មុនថ្ងៃសុក្រនេះ។', 'audience' => 'students', 'priority' => 'medium', 'days_ago' => 9],
            ['title' => 'New Library Books Arrived', 'body' => 'The library has received a new collection of science and literature books. Come check them out during your free periods.', 'audience' => 'everyone', 'priority' => 'medium', 'days_ago' => 18],
            ['title' => 'ការរំលឹកអំពីឯកសណ្ឋានសិស្ស', 'body' => 'សូមសិស្សទាំងអស់ស្លៀកពាក់ឯកសណ្ឋានសាលាឱ្យបានត្រឹមត្រូវរាល់ថ្ងៃសិក្សា។ សូមអរគុណសម្រាប់កិច្ចសហការ។', 'audience' => 'everyone', 'priority' => 'normal', 'days_ago' => 20],
        ];

        foreach ($announcements as $data) {
            $announcement = Announcement::create([
                'author_id' => $author->id,
                'title'     => $data['title'],
                'body'      => $data['body'],
                'audience'  => $data['audience'],
                'class_id'  => $data['class_id'] ?? null,
                'priority'  => $data['priority'],
            ]);

            $announcement->forceFill([
                'created_at' => now()->subDays($data['days_ago']),
                'updated_at' => now()->subDays($data['days_ago']),
            ])->save();
        }
    }
}
