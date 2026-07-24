<?php

namespace App\Notifications;

use App\Models\ScheduleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScheduleRequestSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(private ScheduleRequest $scheduleRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'fa-calendar-check',
            'title'   => 'New Schedule Request',
            'message' => "{$this->scheduleRequest->teacher->user->name} requested {$this->scheduleRequest->subject->name} for {$this->scheduleRequest->schoolClass->name}.",
            'link'    => route('admin.schedule-requests.index'),
        ];
    }
}
