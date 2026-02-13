<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'codigo',
        'tipo',
        'auditor_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'alcance',
        'hallazgos',
        'creado_por',
        'actualizado_por'
    ];

    /**
     * Relación con el auditor
     */
    public function usuarioAuditor()
    {
        return $this->belongsTo(Usuario::class, 'auditor_id');
    }

    /**
     * Relación con usuario creador
     */
    public function creadoPor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    /**
     * Relación con usuario actualizador
     */
    public function actualizadoPor()
    {
        return $this->belongsTo(Usuario::class, 'actualizado_por');
    }
}
