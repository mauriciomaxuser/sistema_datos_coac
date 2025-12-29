<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'codigo',
        'tipo',
        'auditor',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'alcance',
        'hallazgos'
    ];
}
