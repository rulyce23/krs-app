<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'nim', 'name', 'email', 'password', 'major', 'semester'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_courses')
            ->withPivot('academic_year', 'semester', 'status', 'notes')
            ->withTimestamps();
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    /**
     * Get all of the student's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get the student's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->whereNull('read_at')->orderBy('created_at', 'desc');
    }
}
