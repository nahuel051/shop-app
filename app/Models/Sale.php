<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = ['user_id_buyer', 'user_id_seller', 'payment_method', 'total'];

    // Relación: Un 'Sale' pertenece a un usuario comprador
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id_buyer');
    }

    // Relación: Un 'Sale' pertenece a un usuario vendedor
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id_seller');
    }

    // Relación: Un 'Sale' tiene muchos 'DetailsSale'
    public function details()
    {
        return $this->hasMany(DetailsSale::class, 'sale_id');
    }
}
