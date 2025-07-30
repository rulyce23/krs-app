<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'username', 'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get all of the admin's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get the admin's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->whereNull('read_at')->orderBy('created_at', 'desc');
    }
}
