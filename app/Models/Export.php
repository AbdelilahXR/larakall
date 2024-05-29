<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    // make a scope to get only the exports of the user
    public function scopeOfUser($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
