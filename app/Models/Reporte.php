<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'fecha_desde',
        'fecha_hasta',
        'generado_en'
    ];
}
