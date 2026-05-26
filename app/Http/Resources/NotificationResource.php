<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'type'       => $this->data['type'],
            'title'      => __($this->data['title'], $this->data['body_params'] ?? [], app()->getLocale()),
            'body'       => __($this->data['body'], $this->data['body_params'] ?? [], app()->getLocale()),
            'data'       => $this->data,
            'read_at'    => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
