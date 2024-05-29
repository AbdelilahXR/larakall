<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    // id amount state paid_at orders_id
    protected $fillable = [
        'amount',
        'state',
        'paid_at',
        'orders_id'
    ];
}
