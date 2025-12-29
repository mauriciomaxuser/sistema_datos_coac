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
        Schema::create('sujetos_datos', function (Blueprint $table) {
            $table->id();
            $table->string('cedula',20)->unique();
            $table->string('nombre_completo',150);
            $table->string('email',150)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('direccion',200)->nullable();
            $table->string('tipo',50);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sujetos_datos');
    }
};
