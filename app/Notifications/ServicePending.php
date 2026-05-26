<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServicePending extends Notification
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
            'type'          => 'service_pending',
            'service_id'    => $this->serviceId,
            'service_title' => $this->serviceTitle,
            'title'         => 'admin_notifications.service_pending.title',
            'body'          => 'admin_notifications.service_pending.body',
            'body_params'   => ['title' => $this->serviceTitle],
        ];
    }
}
