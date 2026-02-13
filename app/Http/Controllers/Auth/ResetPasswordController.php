<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;   
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function create(Request $request, $token)
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // No existe
        if (!$record) {
            return redirect()->route('password.request')
                ->with('error','Este enlace ya fue utilizado o no es válido');
        }

        // Expirado (60 minutos default)
        $created = Carbon::parse($record->created_at);
        if ($created->addMinutes(config('auth.passwords.users.expire'))->isPast()) {
            return redirect()->route('password.request')
                ->with('error','El enlace de recuperación ha expirado');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success','La contraseña se modificó correctamente');
        }

        return back()->with('error','El enlace ya expiró o es inválido');
    }
}
