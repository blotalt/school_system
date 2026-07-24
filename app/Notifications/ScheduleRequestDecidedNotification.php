<?php

namespace App\Notifications;

use App\Models\ScheduleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScheduleRequestDecidedNotification extends Notification
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
        $approved = $this->scheduleRequest->status === 'approved';

        return [
            'icon'    => $approved ? 'fa-circle-check' : 'fa-circle-xmark',
            'title'   => $approved ? 'Schedule Request Approved' : 'Schedule Request Rejected',
            'message' => "{$this->scheduleRequest->subject->name} for {$this->scheduleRequest->schoolClass->name}.",
            'link'    => route('teacher.schedule.index'),
        ];
    }
}
