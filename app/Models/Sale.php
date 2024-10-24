<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = ['user_id_buyer', 'user_id_seller', 'payment_method', 'total'];

    //relación de pertenencia (belongsTo) entre Sale y User. Aquí, user_id_buyer es la clave foránea en la tabla sales que hace referencia a la tabla users. Indica que cada venta tiene un comprador (usuario). 
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id_buyer');
    }

    //relación de pertenencia (belongsTo) entre Sale y User. Aquí, user_id_seller es la clave foránea en la tabla sales que hace referencia a la tabla users. Indica que cada venta tiene un vendedor (usuario).    
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id_seller');
    }

    //relación de uno a muchos (hasMany) entre Sale y DetailsSale. Aquí, sale_id es la clave foránea en la tabla details_sales que hace referencia a la tabla sales. Indica que una venta puede tener múltiples detalles asociados.
    public function details()
    {
        return $this->hasMany(DetailsSale::class, 'sale_id');
    }
}
