<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'reply_message',
        'replied_at',
        'replied_by_user_id',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function repliedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'replied_by_user_id');
    }
}
