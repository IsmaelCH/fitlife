<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePostComment extends Model
{
    protected $fillable = ['profile_post_id', 'user_id', 'body'];

    public function profilePost()
    {
        return $this->belongsTo(ProfilePost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
