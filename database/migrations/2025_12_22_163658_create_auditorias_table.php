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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',50)->unique();
            $table->string('tipo',50);
            $table->string('auditor',150);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('estado',30);
            $table->text('alcance')->nullable();
            $table->text('hallazgos')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
