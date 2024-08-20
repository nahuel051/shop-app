<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = ['user_id', 'payment_method', 'total'];

    // Relación: Un 'Sale' pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: Un 'Sale' tiene muchos 'DetailsSale'
    public function details()
    {
        return $this->hasMany(DetailsSale::class, 'sale_id');
    }
}
