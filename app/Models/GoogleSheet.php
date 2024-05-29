<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleSheet extends Model
{
    use HasFactory;

    protected $table = 'google_sheets';
    protected $fillable = [
        'sheet_id',
        'sheet_name',
        'matched_columns',
        'last_fetch',
        'success_orders',
    ];
}
