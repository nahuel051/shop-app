<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $table = 'buys';

    protected $fillable = ['user_id_buyer', 'user_id_seller','payment_method', 'total'];


    // Relación: Un 'Buy' pertenece a un usuario comprador
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id_buyer');
    }

    // Relación: Un 'Buy' pertenece a un usuario vendedor
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id_seller');
    }
    
    // Relación: Un 'Buy' tiene muchos 'DetailsBuy'
    public function details()
    {
        return $this->hasMany(DetailsBuy::class, 'buy_id');
    }
}
