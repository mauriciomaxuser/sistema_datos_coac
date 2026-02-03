<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'rol',
        'estado'
    ];

    protected $hidden = [
        'password'
    ];
    public function getRolTextoAttribute()
{
    return match ($this->rol) {
        'admin'    => 'Administrador',
        'dpo'      => 'Oficial de Protección de Datos',
        'auditor'  => 'Auditor',
        'operador' => 'Operador',
        default    => ucfirst($this->rol),
    };
}

}
