<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $media = $this->getFirstMedia('image');

        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'link'       => $this->link,
            'starts_at'  => $this->starts_at?->toISOString(),
            'ends_at'    => $this->ends_at?->toISOString(),
            'image'      => $media ? asset('storage/' . $media->getPathRelativeToRoot()) : null,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
