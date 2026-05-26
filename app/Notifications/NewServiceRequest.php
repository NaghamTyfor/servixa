<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewServiceRequest extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $serviceRequestId,
        public readonly string $serviceTitle,
        public readonly string $requesterName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'               => 'new_service_request',
            'service_request_id' => $this->serviceRequestId,
            'service_title'      => $this->serviceTitle,
            'requester_name'     => $this->requesterName,
            'title'              => 'notifications.new_service_request.title',
            'body'               => 'notifications.new_service_request.body',
            'body_params'        => ['service' => $this->serviceTitle, 'requester' => $this->requesterName],
        ];
    }
}
