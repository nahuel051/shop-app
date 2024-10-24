<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'img',
        'quantity',
        'user_id',
    ];
    // Define la relación entre el producto y el usuario
    // Un producto 'pertenece a' un usuario (relación muchos a uno)
    //public function user(): Define una relación de Eloquent entre el modelo Product y User. Especifica que un producto pertenece a un usuario, lo cual indica una relación "muchos a uno" (muchos productos pueden pertenecer a un solo usuario). El método belongsTo toma como argumento la clase del modelo relacionado (User::class) y la clave foránea (user_id).
    public function user()
    {
        
        return $this->belongsTo(User::class, 'user_id');
    }
}
