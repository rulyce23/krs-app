<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CourseResource extends BaseResource
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
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'credits' => $this->credits,
            'semester' => $this->semester,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'room' => $this->room,
            'lecturer' => $this->lecturer,
            'quota' => $this->quota,
            'is_active' => $this->is_active,
            'enrolled_count' => $this->whenLoaded('studentCourses', function () {
                return $this->studentCourses->where('status', 'approved')->count();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}