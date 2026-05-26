<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BusinessAccountPending extends Notification
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
            'type'                => 'business_account_pending',
            'business_account_id' => $this->businessAccountId,
            'business_name'       => $this->businessName,
            'title'               => 'admin_notifications.business_account_pending.title',
            'body'                => 'admin_notifications.business_account_pending.body',
            'body_params'         => ['name' => $this->businessName],
        ];
    }
}
