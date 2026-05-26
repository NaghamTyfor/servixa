<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceRequestRejected extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $serviceRequestId,
        public readonly string $serviceTitle,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'               => 'service_request_rejected',
            'service_request_id' => $this->serviceRequestId,
            'service_title'      => $this->serviceTitle,
            'title'              => 'notifications.service_request_rejected.title',
            'body'               => 'notifications.service_request_rejected.body',
            'body_params'        => ['service' => $this->serviceTitle],
        ];
    }
}
