<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsSale extends Model
{
    use HasFactory;
    protected $table = 'detail_sales';

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'total'];

    // Relación de pertenencia (belongsTo) entre DetailsSale y Sale. Esto indica que cada detalle de venta pertenece a una venta específica. La clave foránea predeterminada es sale_id, que Eloquent asume basándose en el nombre del modelo relacionado.
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relación de pertenencia (belongsTo) entre DetailsSale y Product. Aquí, product_id es la clave foránea en la tabla detail_sales que se refiere a la tabla products. Esta relación indica que cada detalle de venta pertenece a un producto específico.
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
