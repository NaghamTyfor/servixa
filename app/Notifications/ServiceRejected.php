<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceRejected extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $serviceId,
        public readonly string $serviceTitle,
        public readonly ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'service_rejected',
            'service_id'    => $this->serviceId,
            'service_title' => $this->serviceTitle,
            'title'         => 'notifications.service_rejected.title',
            'body'          => 'notifications.service_rejected.body',
            'body_params'   => ['title' => $this->serviceTitle],
        ];
    }
}
