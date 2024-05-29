<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['sender', 'receiver', 'orders_id', 'is_read', 'last_send'];

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class, 'receiver');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversations_id')->orderBy('id', 'desc');
    }


    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'conversations_id')->latest();
    }

    public function scopeUnreadMessages()
    {
        // scope where reciever is the authenticated user and is_read is 0 in conversation query
        return $this->where('receiver', auth()->id())->where('is_read', 0);
    }
    
}
