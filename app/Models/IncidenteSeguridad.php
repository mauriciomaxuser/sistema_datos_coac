<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidenteSeguridad extends Model
{
    protected $table = 'incidentes_seguridad';

    protected $fillable = [
        'codigo',
        'fecha',
        'severidad',
        'descripcion',
        'tipo',
        'sujetos_afectados',
        'estado'
    ];
}
