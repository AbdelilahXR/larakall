<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    // - `id` - `name` - `api`
    protected $fillable = [
        'name',
        'api'
    ];
}
