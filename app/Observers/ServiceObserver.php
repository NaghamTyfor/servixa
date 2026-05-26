<?php

namespace App\Observers;

use App\Models\Service;
use App\Notifications\ServiceApproved;
use App\Notifications\ServiceRejected;
use App\Services\AdminFcmService;

class ServiceObserver
{
    public function created(Service $service): void
    {
        if ($service->status === 'pending') {
            $adminFcm = app(AdminFcmService::class);
            $serviceTitle = $service->title ?? 'خدمة جديدة';

            $adminFcm->sendToAdminsWithPermission(
                'services.approve',
                'admin_notifications.service_pending.title',
                'admin_notifications.service_pending.body',
                ['title' => $serviceTitle],
                ['type' => 'service_pending', 'id' => $service->id],
                null,
                'service_pending',
                ['id' => $service->id, 'title' => $serviceTitle]
            );
        }
    }

    public function updated(Service $service): void
    {
        if ($service->wasChanged('status')) {
            $businessAccount = $service->businessAccount;
            $serviceTitle = $service->title ?? 'خدمة جديدة';

            if ($businessAccount && $businessAccount->user) {
                $user = $businessAccount->user;

                if ($service->status === 'approved') {
                    $user->notify(new ServiceApproved($service->id, $serviceTitle));
                }
                if ($service->status === 'rejected') {
                    $user->notify(new ServiceRejected($service->id, $serviceTitle, $service->rejection_reason ?? null));
                }
            }
        }
    }
}
