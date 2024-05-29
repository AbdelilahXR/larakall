<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    // id name plateforme link users_id
    protected $fillable = [
        'name',
        'plateforme',
        'link',
        'users_id',
        'status',
        'adding_order_type',
    ];

    // cast
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function scopeFilterByUser($query)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return $query;
        }
        return $query->where('users_id', auth()->id());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'stores_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'stores_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (!auth()->user()->hasRole('super_admin')) {
                $store->users_id = auth()->id();
            }
        });
    }
    
}
