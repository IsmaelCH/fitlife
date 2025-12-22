<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'birthday',
        'bio',
        'profile_photo_path',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'is_admin' => 'boolean',
        'password' => 'hashed',
    ];



    public function news()
    {
        return $this->hasMany(\App\Models\News::class);
    }

    public function newsComments()
    {
        return $this->hasMany(\App\Models\NewsComment::class);
    }


}
