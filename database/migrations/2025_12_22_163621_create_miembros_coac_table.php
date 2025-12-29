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
            $table->string('numero_socio',20)->unique();
            $table->string('cedula',20);
            $table->string('nombre_completo',150);
            $table->date('fecha_ingreso');
            $table->string('categoria',30);
            $table->decimal('aportacion',10,2)->nullable();
            $table->string('estado',20)->default('vigente');
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
