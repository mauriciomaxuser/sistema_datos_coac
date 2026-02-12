<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // <- esto
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Usuario;

class VerificarCorreoUsuario extends Mailable implements ShouldQueue // <- aquí
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
    $url = url('/verificar-correo/' . $this->usuario->email_verificacion_token);

        return $this->subject('Verificación de correo electrónico')
                    ->view('emails.verificar_correo')
                    ->with([
                        'usuario' => $this->usuario,
                        'url' => $url
                    ]);
    }
}
