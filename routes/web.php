<?php
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SujetoDatoController;
use App\Http\Controllers\ProductoFinancieroController;
use App\Http\Controllers\ConsentimientoController;
use App\http\Controllers\ActividadProcesamientoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\IncidenteSeguridadController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\SolicitudDsarController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
//uta para cerrar sesion ---------------------------------
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
 //rutas de usuarios y la que define el index ------------
Route::get('/', [UsuarioController::class, 'index'])->name('index');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');

Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.estado');

// rutas sujetos de datos ---------------------------------
Route::post('/sujetos', [SujetoDatoController::class, 'store'])->name('sujetos.store');
Route::put('/sujetos/{id}', [SujetoDatoController::class, 'update'])->name('sujetos.update');
Route::delete('/sujetos/{id}', [SujetoDatoController::class, 'destroy'])->name('sujetos.destroy');
// Rutas de productos financieros
Route::post('/productos', [ProductoFinancieroController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoFinancieroController::class, 'update'])->name('productos.update');
Route::put('/productos/{id}/estado', [ProductoFinancieroController::class, 'cambiarEstado'])->name('productos.estado');
Route::delete('/productos/{id}', [ProductoFinancieroController::class, 'destroy'])->name('productos.destroy');
Route::delete('/productos/{id}', [ProductoFinancieroController::class, 'destroy'])->name('productos.destroy');

// Rutas de consentimientos ---------------------------------
Route::post('/consentimientos', [ConsentimientoController::class, 'store'])->name('consentimientos.store');
Route::put('/consentimientos/{id}', [ConsentimientoController::class, 'update'])->name('consentimientos.update');
Route::post('/consentimientos/{id}/toggle-activo', [ConsentimientoController::class, 'toggleActivo'])->name('consentimientos.toggleActivo');
Route::delete('/consentimientos/{id}', [ConsentimientoController::class, 'destroy'])->name('consentimientos.destroy');

// rutas de Incidentes ---------------------------------
Route::post('/incidentes', [IncidenteSeguridadController::class, 'store'])->name('incidentes.store');
Route::put('/incidentes/{id}', [IncidenteSeguridadController::class, 'update'])->name('incidentes.update');
Route::delete('/incidentes/{id}', [IncidenteSeguridadController::class, 'destroy'])->name('incidentes.destroy');
Route::get('/incidentes/{id}/edit', [IncidenteSeguridadController::class, 'edit'])->name('incidentes.edit');
Route::get('/incidentes', [IncidenteSeguridadController::class, 'index'])->name('incidentes.index');

// rutas de actividades de procesamiento
Route::get('/actividades-procesamiento', [ActividadProcesamientoController::class, 'index'])->name('actividades.index');
Route::post('/actividades-procesamiento', [ActividadProcesamientoController::class, 'store'])->name('actividades.store');
Route::get('/actividad-procesamiento/ver/{id}',[ActividadProcesamientoController::class, 'ver'])->name('actividad_procesamiento.ver');

// rutas de auditorias ---------------------------------
Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditorias.index');
Route::post('/auditorias', [AuditoriaController::class, 'store'])->name('auditorias.store');
Route::get('/auditoria/ver/{id}', [AuditoriaController::class, 'ver'])->name('auditoria.ver');
Route::get('/auditorias/{id}', [AuditoriaController::class, 'show'])->name('auditorias.show');
// rutas de solicitudes dsar ---------------------------------

Route::get('/', [SolicitudDsarController::class, 'index'])->name('index');

Route::post('/dsar', [SolicitudDsarController::class, 'store'])->name('dsar.store');
Route::put('/dsar/{id}', [SolicitudDsarController::class, 'update'])->name('dsar.update');

// Rutas para miembros
// CRUD miembros
Route::get('/miembros', [MiembroController::class, 'index'])->name('miembros.index');

// Rutas CRUD para miembros
Route::post('/miembros', [MiembroController::class, 'store'])->name('miembros.store');
Route::put('/miembros/{id}', [MiembroController::class, 'update'])->name('miembros.update');
Route::delete('/miembros/{id}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
Route::put('/miembros/{id}/estado', [MiembroController::class, 'cambiarEstado'])->name('miembros.estado');

//rutas del login--------------------------------------------------------------
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('index');
});

// RECUPERAR CONTRASEÑA ----------------------------
// solicitar correo
Route::get('/forgot-password', [ForgotPasswordController::class,'create'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class,'send'])->name('password.email');

// abrir link del correo
Route::get('/reset-password/{token}', [ResetPasswordController::class,'create'])->name('password.reset');

// guardar nueva contraseña
Route::post('/reset-password', [ResetPasswordController::class,'update'])->name('password.update');


// Registro
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');


// validacion para correo unico en usuarios
Route::get('/verificar-email', [UsuarioController::class, 'verificarEmail']);

//- validaciones sujetos
Route::get('/verificar-cedula-sujeto', [SujetoDatoController::class, 'verificarCedula']);
Route::get('/verificar-email-sujeto', [SujetoDatoController::class, 'verificarEmail']);
// ruta para validar nombre unico de usuarios
Route::get('/verificar-nombre', [UsuarioController::class, 'verificarNombre']);
// validar cedula usurio
Route::get('/verificar-cedula', [UsuarioController::class, 'verificarCedula']);
// ruta para verificar el token de verificacion de correo
Route::get('/verificar-correo/{token}', [UsuarioController::class, 'verificarCorreo']);
// Ruta para autocompletar nombre y apellido desde la cédula
Route::get('/api/cedula-externa/{cedula}', [SujetoDatoController::class, 'buscarCedulaExterna'])
    ->name('api.cedula-externa');
