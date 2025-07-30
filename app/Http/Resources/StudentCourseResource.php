<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class StudentCourseResource extends BaseResource
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
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'academic_year' => $this->academic_year,
            'semester' => $this->semester,
            'status' => $this->status,
            'notes' => $this->notes,
            'student' => new StudentResource($this->whenLoaded('student')),
            'course' => new CourseResource($this->whenLoaded('course')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}