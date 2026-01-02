<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)
            ->where('estado', 'activo')
            ->first();

        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Usuario no encontrado o inactivo'
            ]);
        }

        if (!password_verify($request->password, $usuario->password)) {
            return back()->withErrors([
                'password' => 'Contraseña incorrecta'
            ]);
        }

        Auth::login($usuario);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
