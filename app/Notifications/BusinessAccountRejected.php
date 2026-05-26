<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BusinessAccountRejected extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $businessAccountId,
        public readonly string $businessName,
        public readonly ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'                => 'business_account_rejected',
            'business_account_id' => $this->businessAccountId,
            'business_name'       => $this->businessName,
            'title'               => 'notifications.business_account_rejected.title',
            'body'                => 'notifications.business_account_rejected.body',
            'body_params'         => ['name' => $this->businessName],
        ];
    }
}
