<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;

class RatingService
{

    public function create(User $user, Service $service, ServiceRequest $request, array $data): Rating
    {
        if (!$request->isAccepted()) {
            throw new \Exception(__('rating.request_not_accepted'));
        }

        if ($request->service_id !== $service->id) {
            throw new \Exception(__('rating.request_service_mismatch'));
        }

        $userAccountIds = $user->businessAccounts()->pluck('id')->toArray();
        if (!in_array($request->requester_business_account_id, $userAccountIds)) {
            throw new \Exception(__('auth.forbidden'));
        }

        $alreadyRated = Rating::where('request_id', $request->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyRated) {
            throw new \Exception(__('rating.already_rated'));
        }

        return Rating::create([
            'service_id' => $service->id,
            'request_id' => $request->id,
            'user_id'    => $user->id,
            'rating'     => $data['rating'],
            'comment'    => $data['comment'] ?? null,
        ]);
    }


    public function getAverageRating(Service $service): array
    {
        $ratings = Rating::where('service_id', $service->id);

        return [
            'average' => round($ratings->avg('rating'), 1),
            'count'   => $ratings->count(),
        ];
    }


    public function getServiceRatings(Service $service, int $perPage = 10)
    {
        return Rating::where('service_id', $service->id)
            ->with(['user', 'request'])
            ->latest()
            ->paginate($perPage);
    }
}
