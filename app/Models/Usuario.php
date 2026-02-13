<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Notifications\ResetPasswordNotification;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'provincia',
        'ciudad',
        'direccion',
        'email',
        'password',
        'rol',
        'estado',
        'email_verificado',
        'email_verificacion_token'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verificado' => 'boolean', // Convierte automáticamente a true/false
    ];

    /**
     * Retorna el nombre del rol en texto legible
     */
    public function getRolTextoAttribute()
    {
        return match ($this->rol) {
            'admin'                   => 'Administrador',
            'dpo'                     => 'Oficial de Protección de Datos',
            'auditor'                 => 'Auditor',
            'auditor_interno'         => 'Auditor Interno',
            'auditor_externo'         => 'Auditor Externo',
            'operador'                => 'Operador',
            'operador'                => 'Operador',
            'auditor_interno'         => 'Auditor Interno',
            'gestor_consentimientos'  => 'Gestor de Consentimientos',
            'gestor_incidentes'       => 'Gestor de Incidentes',
            'titular'                 => 'Titular',
            default                   => ucfirst($this->rol),
        };
    }

    /**
     * Verificar si es auditor interno
     */
    public function esAuditorInterno()
    {
        return in_array($this->rol, ['auditor_interno', 'auditor']);
    }

    /**
     * Verificar si es auditor externo
     */
    public function esAuditorExterno()
    {
        return $this->rol === 'auditor_externo';
    }

    /**
     * Scope para auditores internos activos
     */
    public function scopeAuditoresInternos($query)
    {
        return $query->whereIn('rol', ['auditor_interno', 'auditor'])
                     ->where('estado', 'activo');
    }

    /**
     * Scope para auditores externos activos
     */
    public function scopeAuditoresExternos($query)
    {
        return $query->where('rol', 'auditor_externo')
                     ->where('estado', 'activo');
    }

    /**
     * Scope para filtrar por tipo de auditoría
     */
    public function scopePorTipoAuditoria($query, $tipo)
    {
        if ($tipo === 'interna') {
            return $query->auditoresInternos();
        } elseif ($tipo === 'externa') {
            return $query->auditoresExternos();
        }
        return $query;
    }

    /**
     * Obtener nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }


    /**
     * Envia el correo de recuperación de contraseña al usuario
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    /**
     * Eventos del modelo
     */
    protected static function booted()
    {
        static::creating(function ($usuario) {
            // Genera un token único si no existe
            if (!$usuario->email_verificacion_token) {
                $usuario->email_verificacion_token = Str::uuid();
            }

            // Usuario nuevo siempre inactivo hasta verificar correo
            $usuario->estado = 'inactivo';
            $usuario->email_verificado = false;
        });
    }
}


