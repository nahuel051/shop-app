<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $table = 'buys';

    protected $fillable = ['user_id', 'total'];

    // Relación: Un 'Buy' pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // Relación: Un 'Buy' tiene muchos 'DetailsBuy'
    public function details()
    {
        return $this->hasMany(DetailsBuy::class, 'buy_id');
    }
}
