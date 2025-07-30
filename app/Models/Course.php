<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'credits', 'semester', 'day', 'start_time', 'end_time', 'room', 'lecturer', 'quota', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses');
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
