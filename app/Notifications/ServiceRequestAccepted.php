<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceRequestAccepted extends Notification
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
            'type'               => 'service_request_accepted',
            'service_request_id' => $this->serviceRequestId,
            'service_title'      => $this->serviceTitle,
            'title'              => 'notifications.service_request_accepted.title',
            'body'               => 'notifications.service_request_accepted.body',
            'body_params'        => ['service' => $this->serviceTitle],
        ];
    }
}
