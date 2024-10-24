<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $table = 'buys';

    protected $fillable = ['user_id_buyer', 'user_id_seller','payment_method', 'total'];


    //relación (belongsTo) entre Buy y User, donde user_id_buyer es la clave foránea en la tabla buys que referencia a la tabla users. Esto significa que cada compra tiene un usuario comprador.
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id_buyer');
    }

    //relación (belongsTo) entre Buy y User, donde user_id_seller es la clave foránea en la tabla buys que referencia a la tabla users. Esto significa que cada compra tiene un usuario vendedor.
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id_seller');
    }
    
    //relación de uno a muchos (hasMany) entre Buy y DetailsBuy, donde buy_id es la clave foránea en la tabla details_buys que referencia a la tabla buys. Esto significa que una compra puede tener muchos detalles de compra.   
    public function details()
    {
        return $this->hasMany(DetailsBuy::class, 'buy_id');
    }
}
