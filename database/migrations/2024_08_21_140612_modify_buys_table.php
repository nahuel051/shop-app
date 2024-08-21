<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buys', function (Blueprint $table) {
            // Renombrar el campo user_id a user_id_seller
            $table->renameColumn('user_id', 'user_id_seller');
            // Asegurarse de que la clave foránea esté configurada correctamente
            $table->foreign('user_id_seller')->references('id')->on('users')->onDelete('cascade');

            // Agregar el nuevo campo user_id_buyer
            $table->foreignId('user_id_buyer')->after('user_id_seller')->constrained('users')->onDelete('cascade');
            // Agregar el nuevo campo payment_method
            $table->string('payment_method')->after('user_id_buyer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buys', function (Blueprint $table) {
            // Eliminar las claves foráneas primero
            $table->dropForeign(['user_id_seller']);
            $table->dropForeign(['user_id_buyer']);

            // Revertir el nombre del campo
            $table->renameColumn('user_id_seller', 'user_id');

            // Eliminar el campo user_id_buyer
            $table->dropColumn('user_id_buyer');
        });
    }
};
