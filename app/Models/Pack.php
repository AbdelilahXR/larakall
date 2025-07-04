<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    // - `id` - `name` - `feautures` - `price`
    protected $fillable = [
        'name',
        'feautures',
        'price'
    ];
}
