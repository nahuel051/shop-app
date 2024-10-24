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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('city');
            $table->string('address');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        //TABLA PARA LOS TOKENS DE RESTABLECIMIENTO DE CONTRASEÑA.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // La dirección de correo electrónico del usuario que solicita el restablecimiento
            $table->string('token'); // El token único generado para la solicitud de restablecimiento de contraseña
            $table->timestamp('created_at')->nullable();
        });
        //TABLA PARA LAS SESIONES DE USUARIOS.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // El identificador único de la sesión
            $table->foreignId('user_id')->nullable()->index(); // La referencia al ID del usuario asociado a la sesión, si existe
            $table->string('ip_address', 45)->nullable(); // La dirección IP desde la que se creó la sesión
            $table->text('user_agent')->nullable(); // La información del agente de usuario (navegador) utilizado
            $table->longText('payload'); // Los datos serializados de la sesión
            $table->integer('last_activity')->index(); // La última vez que la sesión fue activada, en formato de timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
