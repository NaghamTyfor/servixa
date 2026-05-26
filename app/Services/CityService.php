<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;

class CityService
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return City::orderBy('id', 'desc')->paginate($perPage);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return City::orderBy('id', 'asc')->get();
    }

    public function create(array $data): City
    {
        return City::create([
            'name' => [
                'ar' => $data['name_ar'],
                'en' => $data['name_en'],
            ],
        ]);
    }

    public function update(City $city, array $data): City
    {
        $city->setTranslations('name', [
            'ar' => $data['name_ar'],
            'en' => $data['name_en'],
        ]);
        $city->save();

        return $city->fresh();
    }

    public function delete(City $city): void
    {
        $city->delete();
    }

    public function searchAndPaginate(?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = City::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name->ar', 'like', "%{$search}%")
                  ->orWhere('name->en', 'like', "%{$search}%");
            });
        }

        return $query
            ->withCount(['users', 'businessAccounts'])
            ->latest()
            ->paginate($perPage)
            ->appends(['search' => $search]);
    }

    public function bulkDelete(array $ids): int
    {
        return City::whereIn('id', $ids)->delete();
    }
}
