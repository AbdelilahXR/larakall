<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'messages_id',
        'users_id',
        'conversations_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
