<?php

namespace App\Observers;

use App\Models\BusinessAccount;
use App\Notifications\BusinessAccountApproved;
use App\Notifications\BusinessAccountRejected;
use App\Services\AdminFcmService;

class BusinessAccountObserver
{
    public function created(BusinessAccount $businessAccount): void
    {
        if ($businessAccount->status === 'pending') {
            $adminFcm = app(AdminFcmService::class);
            $businessName = $businessAccount->business_name ?? 'حساب جديد';

            $adminFcm->sendToAdminsWithPermission(
                'business_accounts.approve',
                'admin_notifications.business_account_pending.title',
                'admin_notifications.business_account_pending.body',
                ['name' => $businessName],
                ['type' => 'business_account_pending', 'id' => $businessAccount->id],
                null,
                'business_account_pending',
                ['id' => $businessAccount->id, 'name' => $businessName]
            );
        }
    }

    public function updated(BusinessAccount $businessAccount): void
    {
        if ($businessAccount->wasChanged('status')) {
            $user = $businessAccount->user;
            $businessName = $businessAccount->business_name ?? 'حساب جديد';

            if ($user) {
                if ($businessAccount->status === 'approved') {
                    $user->notify(new BusinessAccountApproved($businessAccount->id, $businessName));
                }
                if ($businessAccount->status === 'rejected') {
                    $user->notify(new BusinessAccountRejected($businessAccount->id, $businessName, $businessAccount->rejection_reason ?? null));
                }
            }
        }
    }
}
