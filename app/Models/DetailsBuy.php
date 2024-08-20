<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsBuy extends Model
{
    use HasFactory;
    protected $table = 'detail_buys';

    protected $fillable = ['buy_id', 'product_id', 'quantity', 'total'];

    // Relación: Un 'DetailsBuy' pertenece a un 'Buy'
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    // Relación: Un 'DetailsBuy' pertenece a un 'Product'
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
