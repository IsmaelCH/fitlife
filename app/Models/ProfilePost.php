<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePost extends Model
{
    protected $fillable = ['profile_user_id', 'author_user_id', 'body'];

    public function profileUser()
    {
        return $this->belongsTo(User::class, 'profile_user_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_user_id');
    }
}
