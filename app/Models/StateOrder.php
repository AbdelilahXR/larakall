<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateOrder extends Model
{
    use HasFactory;
    protected $table = 'states_orders';

    protected $fillable = [
        'states_id', 'orders_id', 'users_id', 'created_at'
    ];

    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class, 'states_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    
}
