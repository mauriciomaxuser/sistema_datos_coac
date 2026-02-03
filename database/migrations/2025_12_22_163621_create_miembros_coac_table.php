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
        Schema::create('miembros_coac', function (Blueprint $table) {
            $table->id();

            // Número de socio autogenerado (NO se ingresa manualmente)
            $table->unsignedBigInteger('numero_socio')->unique();

            $table->string('cedula', 20);

            // Nombres y apellidos separados
            $table->string('nombres', 100);
            $table->string('apellidos', 100);

            // Fecha válida desde 1920 hasta hoy (se valida en backend y frontend)
            $table->date('fecha_ingreso');

            $table->string('categoria', 30);

            // Aportación inicial (máx 10.000 validado en backend)
            $table->decimal('aportacion', 10, 2)->default(0);

            $table->string('estado', 20)->default('vigente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros_coac');
    }
};
