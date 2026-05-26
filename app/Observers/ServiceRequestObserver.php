<?php

namespace App\Observers;

use App\Models\BusinessAccount;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\NewServiceRequest;
use App\Notifications\ServiceRequestAccepted;
use App\Notifications\ServiceRequestRejected;
use Illuminate\Support\Facades\Log;

class ServiceRequestObserver
{
    public function created(ServiceRequest $serviceRequest): void
    {
        $providerAccount = BusinessAccount::find($serviceRequest->provider_business_account_id);
        if (!$providerAccount || !$providerAccount->user_id) {
            Log::warning('No provider user_id', [
                'provider_business_account_id' => $serviceRequest->provider_business_account_id,
                'found' => !is_null($providerAccount),
                'user_id' => $providerAccount->user_id ?? null
            ]);
            return;
        }

        $providerUser = User::find($providerAccount->user_id);
        if (!$providerUser) {
            Log::warning('Provider user not found', ['user_id' => $providerAccount->user_id]);
            return;
        }

        $serviceTitle = $serviceRequest->service->title ?? 'خدمة جديدة';
        $requesterName = optional($serviceRequest->requesterBusinessAccount)->business_name ?? 'مستخدم';

        $providerUser->notify(new NewServiceRequest($serviceRequest->id, $serviceTitle, $requesterName));
    }

    public function updated(ServiceRequest $serviceRequest): void
    {
        if (!$serviceRequest->wasChanged('status')) return;


        $requesterAccount = BusinessAccount::find($serviceRequest->requester_business_account_id);
        if (!$requesterAccount || !$requesterAccount->user_id) {
            Log::warning('No requester user_id', [
                'requester_business_account_id' => $serviceRequest->requester_business_account_id,
                'found' => !is_null($requesterAccount),
                'user_id' => $requesterAccount->user_id ?? null
            ]);
            return;
        }

        $requesterUser = User::find($requesterAccount->user_id);
        if (!$requesterUser) {
            Log::warning('Requester user not found', ['user_id' => $requesterAccount->user_id]);
            return;
        }

        $serviceTitle = $serviceRequest->service->title ?? 'خدمة جديدة';

        if ($serviceRequest->status === 'accepted') {
            $requesterUser->notify(new ServiceRequestAccepted($serviceRequest->id, $serviceTitle));
        } elseif ($serviceRequest->status === 'rejected') {
            $requesterUser->notify(new ServiceRequestRejected($serviceRequest->id, $serviceTitle));
        }
    }
}
