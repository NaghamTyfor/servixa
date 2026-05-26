<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'reason'     => $this->reason,
            'created_at' => $this->created_at->toISOString(),
            'user'       => UserResource::make($this->whenLoaded('user')),
            'service'    => ServiceResource::make($this->whenLoaded('service')),
        ];
    }
}
