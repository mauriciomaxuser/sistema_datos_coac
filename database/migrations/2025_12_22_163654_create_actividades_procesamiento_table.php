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
        Schema::create('actividades_procesamiento', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',50)->unique();
            $table->string('nombre',150);
            $table->string('responsable',150);
            $table->text('finalidad');
            $table->string('base_legal',50);
            $table->string('categorias_datos',200)->nullable();
            $table->string('plazo_conservacion',100)->nullable();
            $table->text('medidas_seguridad')->nullable();
            $table->string('estado',20)->default('activa');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_procesamiento');
    }
};
