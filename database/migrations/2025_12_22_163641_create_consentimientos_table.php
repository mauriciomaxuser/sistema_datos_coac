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
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sujeto_id')->constrained('sujetos_datos')->cascadeOnDelete();
            $table->string('proposito',100);
            $table->string('estado',30);
            $table->date('fecha_otorgamiento')->nullable();
            $table->string('metodo',50)->nullable();
            $table->date('fecha_expiracion')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimientos');
    }
};
