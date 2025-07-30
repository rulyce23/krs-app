<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class NotificationResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
            'read_at' => $this->read_at,
            'is_read' => $this->read(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}