<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(private Announcement $announcement)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'fa-bullhorn',
            'title'   => 'New Announcement',
            'message' => $this->announcement->title,
            'link'    => $this->linkFor($notifiable),
        ];
    }

    private function linkFor(object $notifiable): string
    {
        return match ($notifiable->role) {
            'admin'   => route('admin.announcements.index'),
            'teacher' => route('teacher.announcements'),
            'student' => route('student.announcements'),
            default   => '/',
        };
    }
}
