<?php

namespace App\Notifications;

use App\Models\ExamResult;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExamGradedNotification extends Notification
{
    use Queueable;

    public function __construct(private ExamResult $result)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $exam = $this->result->exam;

        return [
            'icon'    => 'fa-clipboard-check',
            'title'   => 'Exam Graded',
            'message' => ($exam->subject->name ?? 'Exam') . ': ' . $this->result->score . '/' . $exam->max_score,
            'link'    => route('student.grades.index'),
        ];
    }
}
