<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;
    
    protected $table = 'stocks_products';
    
    protected $fillable = [
        'stocks_id',
        'products_id',
        'quantity',
        'unit_price',
    ];
    
    public $timestamps = false;

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stocks_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->unit_price;
    }


}
