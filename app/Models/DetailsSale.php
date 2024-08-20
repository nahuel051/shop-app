<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsSale extends Model
{
    use HasFactory;
    protected $table = 'detail_sales';

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'total'];

    // Relación: Un 'DetailsSale' pertenece a un 'Sale'
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relación: Un 'DetailsSale' pertenece a un 'Product'
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
