<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        $mainImageMedia = $this->getFirstMedia('main_image');

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'quantity'     => $this->quantity,
            'service_type' => $this->service_type,
            'price_syp'    => $this->price_syp,
            'price_usd'    => $this->price_usd,
            'lat'          => $this->lat,
            'lng'          => $this->lng,
            'status'       => $this->status,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'reviewed_at'  => $this->reviewed_at?->toISOString(),

            'average_rating' => $this->average_rating,
            'ratings_count'  => $this->ratings_count,

            'category'             => CategoryResource::make($this->whenLoaded('category')),
            'sub_category'         => SubCategoryResource::make($this->whenLoaded('subCategory')),
            'business_account'     => BusinessAccountResource::make($this->whenLoaded('businessAccount')),
            'dynamic_field_values' => DynamicFieldValueResource::collection(
                $this->whenLoaded('dynamicFieldValues')
            ),

            'main_image' => $mainImageMedia
                ? asset('storage/' . $mainImageMedia->getPathRelativeToRoot())
                : null,
            'main_image_id' => $mainImageMedia?->id,

            'images' => $this->getMedia('images')->map(fn($m) => [
                'id'  => $m->id,
                'url' => asset('storage/' . $m->getPathRelativeToRoot()),
            ]),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
