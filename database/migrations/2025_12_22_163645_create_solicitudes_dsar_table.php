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
        Schema::create('solicitudes_dsar', function (Blueprint $table) {
            $table->id();
            $table->string('numero_solicitud',50)->unique();
            $table->foreignId('sujeto_id')->constrained('sujetos_datos')->cascadeOnDelete();
            $table->string('tipo',50);
            $table->text('descripcion');
            $table->date('fecha_solicitud');
            $table->date('fecha_limite')->nullable();
            $table->string('estado',30);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_dsar');
    }
};
