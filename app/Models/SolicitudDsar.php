<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDsar extends Model
{
    protected $table = 'solicitudes_dsar';

    protected $fillable = [
        'numero_solicitud',
        'sujeto_id',
        'tipo',
        'descripcion',
        'fecha_solicitud',
        'fecha_limite',
        'estado'
    ];

    public function sujeto()
    {
        return $this->belongsTo(SujetoDato::class, 'sujeto_id');
    }
}
