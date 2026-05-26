<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $reportId,
        public readonly string $serviceTitle,
        public readonly string $reason
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'report_submitted',
            'report_id'     => $this->reportId,
            'service_title' => $this->serviceTitle,
            'reason'        => $this->reason,
            'title'         => 'admin_notifications.report_submitted.title',
            'body'          => 'admin_notifications.report_submitted.body',
            'body_params'   => [
                'service' => $this->serviceTitle,
                'reason'  => $this->reason
            ],
        ];
    }
}
