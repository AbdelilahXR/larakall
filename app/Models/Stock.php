<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'stores_id',
    ];

    // ToDo: add this method to the StockHelper class
    public static function generateReference($length = 8)
    {
        $today = date('j');
        $month = date('n');
        $year = date('y');
        $reference = 'S-' . $year . $month . $today . strtoupper(Str::random(4));

        return $reference;
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'stocks_products', 'stocks_id', 'products_id')
            ->withPivot('quantity', 'unit_price')
            ->using(StockProduct::class);
    }

    public function stockProducts()
    {
        return $this->hasMany(StockProduct::class, 'stocks_id');
    }

    public function productDetail()
    {
        return $this->hasManyThrough(
            Product::class,
            StockProduct::class,
            'stocks_id',
            'id',
            'id',
            'products_id'
        );
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }


    // get QR code
    public function getQrCodeAttribute()
    {
        return QrCode::size(150)->generate($this->reference);
    }




}
