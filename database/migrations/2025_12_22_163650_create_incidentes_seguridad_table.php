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
        Schema::create('incidentes_seguridad', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',50)->unique();
            $table->timestamp('fecha');
            $table->string('severidad',30);
            $table->text('descripcion');
            $table->string('tipo',50);
            $table->integer('sujetos_afectados')->nullable();
            $table->string('estado',30);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidentes_seguridad');
    }
};
