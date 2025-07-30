<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id', 'course_id', 'academic_year', 'semester', 'status', 'notes'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
