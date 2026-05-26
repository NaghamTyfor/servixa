<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceApproved extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $serviceId,
        public readonly string $serviceTitle,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'service_approved',
            'service_id'    => $this->serviceId,
            'service_title' => $this->serviceTitle,
            'title'         => 'notifications.service_approved.title',
            'body'          => 'notifications.service_approved.body',
            'body_params'   => ['title' => $this->serviceTitle],
        ];
    }
}
