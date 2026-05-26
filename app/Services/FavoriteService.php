<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Service;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class FavoriteService
{
    public function toggle(User $user, Service $service): array
    {
        $favorite = Favorite::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return ['added' => false];
        }

        Favorite::create([
            'user_id'    => $user->id,
            'service_id' => $service->id,
        ]);

        return ['added' => true];
    }

public function paginate(User $user, int $perPage = 15): LengthAwarePaginator
{
    return Favorite::where('user_id', $user->id)
        ->with(['service' => function ($q) {
            $q->with(['businessAccount', 'media'])
              ->withAvg('ratings', 'rating');
        }])
        ->latest()
        ->paginate($perPage);
}

    public function isFavorited(User $user, Service $service): bool
    {
        return Favorite::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->exists();
    }
}
