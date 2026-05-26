<?php

namespace App\Services;

use App\Models\ActivityType;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityTypeService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return ActivityType::orderBy('id', 'desc')->paginate($perPage);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return ActivityType::orderBy('id', 'asc')->get();
    }

    public function create(array $data): ActivityType
    {
        return ActivityType::create([
            'name' => [
                'ar' => $data['name_ar'],
                'en' => $data['name_en'],
            ],
        ]);
    }

    public function update(ActivityType $activityType, array $data): ActivityType
    {
        $activityType->setTranslations('name', [
            'ar' => $data['name_ar'],
            'en' => $data['name_en'],
        ]);
        $activityType->save();

        return $activityType->fresh();
    }

    public function delete(ActivityType $activityType): void
    {
        $activityType->delete();
    }

    public function searchAndPaginate(?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = ActivityType::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name->ar', 'like', "%{$search}%")
                ->orWhere('name->en', 'like', "%{$search}%");
            });
        }

        return $query
            ->withCount('businessAccounts')
            ->latest()
            ->paginate($perPage)
            ->appends(['search' => $search]);
    }
}
