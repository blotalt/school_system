<?php

namespace App\Notifications;

use App\Models\Homework;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HomeworkAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(private Homework $homework)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'fa-book',
            'title'   => 'New Homework',
            'message' => $this->homework->title . ' (' . ($this->homework->subject->name ?? 'General') . ')',
            'link'    => route('student.view-task', $this->homework),
        ];
    }
}
