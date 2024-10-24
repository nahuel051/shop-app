<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsBuy extends Model
{
    use HasFactory;
    protected $table = 'detail_buys';

    protected $fillable = ['buy_id', 'product_id', 'quantity', 'total'];

    // Relación de pertenencia (belongsTo) entre DetailsBuy y Buy. Esta relación indica que cada detalle de compra pertenece a una compra específica. No es necesario especificar la clave foránea en este caso, ya que Eloquent asume que la clave foránea es buy_id por defecto, basada en el nombre del modelo relacionado.
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    // Relación de pertenencia (belongsTo) entre DetailsBuy y Product. Aquí, product_id es la clave foránea en la tabla detail_buys que hace referencia a la tabla products. Esta relación indica que cada detalle de compra pertenece a un producto específico.
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
