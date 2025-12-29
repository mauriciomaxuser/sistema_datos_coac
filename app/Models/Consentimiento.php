<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consentimiento extends Model
{
    protected $table = 'consentimientos';

    protected $fillable = [
        'sujeto_id',
        'proposito',
        'estado',
        'fecha_otorgamiento',
        'metodo',
        'fecha_expiracion'
    ];

    public function sujeto()
    {
        return $this->belongsTo(SujetoDato::class, 'sujeto_id');
    }
}
