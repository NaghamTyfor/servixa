<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Exception;

class SliderService
{
    public function searchAndPaginate(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Slider::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title->ar', 'like', "%{$search}%")
                ->orWhere('title->en', 'like', "%{$search}%");
            });
        }

        return $query
            ->latest()
            ->paginate($perPage)
            ->appends(['search' => $search]);
    }

public function activeForApi(): \Illuminate\Database\Eloquent\Collection
{
    return Slider::active()
                 ->latest()
                 ->get();
}

    public function create(array $data): Slider
    {
        $slider = Slider::create([
            'title' => [
                'ar' => $data['title_ar'],
                'en' => $data['title_en'],
            ],
            'link'      => $data['link'] ?? null,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at'   => $data['ends_at'] ?? null,
        ]);

        if (!empty($data['image'])) {
            $slider->addMedia($data['image'])->toMediaCollection('image');
        }

        return $slider->fresh();
    }

public function update(Slider $slider, array $data): Slider
{
    $slider->setTranslations('title', [
        'ar' => $data['title_ar'] ?? $slider->getTranslation('title', 'ar'),
        'en' => $data['title_en'] ?? $slider->getTranslation('title', 'en'),
    ]);

    if (array_key_exists('link', $data)) {
        $slider->link = $data['link'];
    }
    if (array_key_exists('starts_at', $data)) {
        $slider->starts_at = $data['starts_at'];
    }
    if (array_key_exists('ends_at', $data)) {
        $slider->ends_at = $data['ends_at'];
    }

    $slider->save();

    if (!empty($data['image'])) {
        $slider->clearMediaCollection('image');
        $slider->addMedia($data['image'])->toMediaCollection('image');
    }

    return $slider->fresh();
}

    public function delete(Slider $slider): void
    {
        $slider->clearMediaCollection('image');
        $slider->delete();
    }

public function toggleActive(Slider $slider): Slider
{
    $now = now();

    if (!$slider->is_active) {
        $startsValid = is_null($slider->starts_at) || $slider->starts_at <= $now;
        $endsValid   = is_null($slider->ends_at)   || $slider->ends_at >= $now;

        if (!$startsValid || !$endsValid) {
            throw new Exception(__('admin.cannot_activate_outside_schedule'));
        }
    }

    $slider->is_active = !$slider->is_active;
    $slider->save();

    return $slider;
}
}
