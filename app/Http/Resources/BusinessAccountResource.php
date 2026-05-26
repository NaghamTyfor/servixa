<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'user'          => [
                'full_name'  => $this->user->full_name,
                'phone'      => $this->user->phone,
            ],
            'business_name' => $this->business_name,
            'license_number'=> $this->license_number,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'activities'    => $this->activities,
            'details'       => $this->details,
            'status'        => $this->status,
            'is_active'     => $this->is_active,
            'submitted_at'  => $this->submitted_at?->toISOString(),
            'reviewed_at'   => $this->reviewed_at?->toISOString(),
            'activity_type' => ActivityTypeResource::make($this->whenLoaded('activityType')),
            'city'          => CityResource::make($this->whenLoaded('city')),

            'images' => $this->getMedia('images')->map(fn($m) => [
                'id'    => $m->id,
                'url'   => asset('storage/' . $m->getPathRelativeToRoot()),
                'thumb' => $m->hasGeneratedConversion('thumb')
                    ? asset('storage/' . $m->getPathRelativeToRoot('thumb'))
                    : asset('storage/' . $m->getPathRelativeToRoot()),
            ]),

            'documents' => $this->getMedia('documents')->map(fn($m) => [
                'id'      => $m->id,
                'url'     => asset('storage/' . $m->getPathRelativeToRoot()),
                'name'    => $m->file_name,
                'mime'    => $m->mime_type,
                'size_kb' => round($m->size / 1024, 1),
            ]),

            'created_at'    => $this->created_at->toISOString(),
        ];
    }
}
