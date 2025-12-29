<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoFinanciero extends Model
{
    protected $table = 'productos_financieros';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
        'datos_procesados',
        'estado'
    ];
}
