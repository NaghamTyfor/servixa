<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BusinessAccountApproved extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $businessAccountId,
        public readonly string $businessName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'                => 'business_account_approved',
            'business_account_id' => $this->businessAccountId,
            'business_name'       => $this->businessName,
            'title'               => 'notifications.business_account_approved.title',
            'body'                => 'notifications.business_account_approved.body',
            'body_params'         => ['name' => $this->businessName],
        ];
    }
}
