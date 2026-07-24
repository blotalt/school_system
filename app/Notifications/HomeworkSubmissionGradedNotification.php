<?php

namespace App\Notifications;

use App\Models\HomeworkSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HomeworkSubmissionGradedNotification extends Notification
{
    use Queueable;

    public function __construct(private HomeworkSubmission $submission)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $homework = $this->submission->homework;

        return [
            'icon'    => 'fa-book',
            'title'   => 'Homework Graded',
            'message' => $homework->title . ': ' . $this->submission->score . '/100',
            'link'    => route('student.view-task', $homework),
        ];
    }
}
