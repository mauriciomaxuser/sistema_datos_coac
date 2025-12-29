<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SujetoDato extends Model
{
    protected $table = 'sujetos_datos';

    protected $fillable = [
        'cedula',
        'nombre_completo',
        'email',
        'telefono',
        'direccion',
        'tipo'
    ];
}
