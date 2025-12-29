<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiembroCoac extends Model
{
    protected $table = 'miembros_coac';

    protected $fillable = [
        'numero_socio',
        'cedula',
        'nombre_completo',
        'fecha_ingreso',
        'categoria',
        'aportacion',
        'estado'
    ];
}
