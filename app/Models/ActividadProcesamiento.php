<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadProcesamiento extends Model
{
    use HasFactory;

    protected $table = 'actividades_procesamiento';

    protected $fillable = [
        'codigo',
        'nombre',
        'responsable',
        'finalidad',
        'base_legal',
        'categorias_datos',
        'plazo_conservacion',
        'medidas_seguridad',
        'estado'
    ];
}
