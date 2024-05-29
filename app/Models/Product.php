<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'upsell' => 'array',
    ];

    protected $fillable = [
        'name',
        'script',
        'upsell',
        'image_1',
        'image_2',
        'image_3',
        'link',
        'description',
        'min_price',
        'max_price',
        'stores_id',
        'type',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }

    public function variants()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function stockProducts()
    {
        return $this->hasMany(StockProduct::class, 'products_id');
    }

    public function getStockProductsCountAttribute()
    {
        return  ($this->stockProducts()
                    ->whereHas('stock',fn ($query) => $query->where('deleted_at', null))
                    ->sum('quantity') ?? 0);
    }

    public function getStockProductsWithVariantsCountAttribute()
    {
        return  ($this->stockProducts()
                    ->whereHas('stock',fn ($query) => $query->where('deleted_at', null))
                    ->sum('quantity') ?? 0)
                +
                ($this->variants->flatMap(function ($variant) {
                    return $variant->stockProducts()
                        ->whereHas('stock', fn ($query) => $query->where('deleted_at', null))
                        ->get();
                })->sum('quantity') ?? 0);
    }

    public function getFullNameAttribute()
    {
        return $this->parentProduct ? $this->parentProduct->name . ' | Variant: ' . $this->name : $this->name;
    }


    public function scopeFilterByUser($query)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return $query;
        }

        return $query->whereHas('store', function ($query) {
            $query->where('users_id', auth()->id());
        });

    }


    public function scopeFilterByUserStores($query)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return $query;
        }

        return $query->whereHas('store', function ($query) {
            $query->where('users_id', auth()->id());
        });

    }


    

    
}
