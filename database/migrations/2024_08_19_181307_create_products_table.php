<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('quantity');
            // Columna 'price' para almacenar el precio del producto, con hasta 10 dígitos y 2 decimales
            $table->decimal('price', 10, 2);
            // Columna 'img' para almacenar la ruta o nombre de archivo de la imagen del producto
            $table->string('img');
            // 'user_id' clave foránea, referencia a la tabla 'users'
            // 'constrained' establece la relación, 'onDelete('cascade')' si se elimina el usuario, todos los productos asociados también se eliminarán.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
