<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    // - `id` - `name` - `color` - `type`
    protected $fillable = [
        'name',
        'color',
        'type',
        'show_stat'
    ];
}
