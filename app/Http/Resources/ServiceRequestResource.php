<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'status'              => $this->status,
            'needed_time'         => $this->needed_time?->toISOString(),
            'details'             => $this->details,
            'quantity'            => $this->quantity,
            'service'             => ServiceResource::make($this->whenLoaded('service')),
            'requester_account'   => BusinessAccountResource::make($this->whenLoaded('requesterAccount')),
            'provider_account'    => BusinessAccountResource::make($this->whenLoaded('providerAccount')),
            'rating'              => RatingResource::make($this->whenLoaded('rating')),
            'created_at'          => $this->created_at?->toISOString(),
            'updated_at'          => $this->updated_at?->toISOString(),
        ];
    }
}
