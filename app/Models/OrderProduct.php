<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_products';

    public $timestamps = false;

    protected $fillable = [
        'orders_id',
        'products_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'unit_price' => 'float'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function orderUser()
    {
        return $this->belongsTo(OrderUser::class, 'orders_id', 'orders_id');
    }

    public function scopeOfStore($query, $store_id)
    {
        
        if ($store_id == null) {

            if (auth()->user()->hasRole('super_admin')) {
                return $query;
            }

            return $query->whereHas(
                'orderUser', function ($query) {
                    $query->where('users_id', auth()->id());
                }
            );
        }

        return $query->whereHas(
            'order', function ($query) use ($store_id) {
                $query->where('stores_id', $store_id);
            }
        );
    }
}
