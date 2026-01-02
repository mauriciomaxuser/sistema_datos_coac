<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SujetoDatoController;
use App\Http\Controllers\ProductoFinancieroController;
use App\Http\Controllers\ConsentimientoController;
use App\Http\Controllers\ActividadProcesamientoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\IncidenteSeguridadController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\SolicitudDsarController;

/*
|--------------------------------------------------------------------------
| RUTAS PUBLICAS (SIN LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (CON LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // INDEX (AL ABRIR EL SISTEMA)
    Route::get('/', [UsuarioController::class, 'index'])->name('index');

    // LOGOUT
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // USUARIOS
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.estado');

    // SUJETOS DE DATOS
    Route::post('/sujetos', [SujetoDatoController::class, 'store'])->name('sujetos.store');
    Route::put('/sujetos/{id}', [SujetoDatoController::class, 'update'])->name('sujetos.update');
    Route::delete('/sujetos/{id}', [SujetoDatoController::class, 'destroy'])->name('sujetos.destroy');

    // PRODUCTOS FINANCIEROS
    Route::post('/productos', [ProductoFinancieroController::class, 'store'])->name('productos.store');
    Route::put('/productos/{id}', [ProductoFinancieroController::class, 'update'])->name('productos.update');
    Route::put('/productos/{id}/estado', [ProductoFinancieroController::class, 'cambiarEstado'])->name('productos.estado');
    Route::delete('/productos/{id}', [ProductoFinancieroController::class, 'destroy'])->name('productos.destroy');

    // CONSENTIMIENTOS
    Route::post('/consentimientos', [ConsentimientoController::class, 'store'])->name('consentimientos.store');
    Route::put('/consentimientos/{id}', [ConsentimientoController::class, 'update'])->name('consentimientos.update');
    Route::delete('/consentimientos/{id}', [ConsentimientoController::class, 'destroy'])->name('consentimientos.destroy');

    // INCIDENTES
    Route::get('/incidentes', [IncidenteSeguridadController::class, 'index'])->name('incidentes.index');
    Route::get('/incidentes/{id}/edit', [IncidenteSeguridadController::class, 'edit'])->name('incidentes.edit');
    Route::post('/incidentes', [IncidenteSeguridadController::class, 'store'])->name('incidentes.store');
    Route::put('/incidentes/{id}', [IncidenteSeguridadController::class, 'update'])->name('incidentes.update');
    Route::delete('/incidentes/{id}', [IncidenteSeguridadController::class, 'destroy'])->name('incidentes.destroy');

    // ACTIVIDADES DE PROCESAMIENTO
    Route::get('/actividades-procesamiento', [ActividadProcesamientoController::class, 'index'])->name('actividades.index');
    Route::post('/actividades-procesamiento', [ActividadProcesamientoController::class, 'store'])->name('actividades.store');
    Route::get('/actividad-procesamiento/ver/{id}', [ActividadProcesamientoController::class, 'ver'])->name('actividad_procesamiento.ver');

    // AUDITORIAS
    Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditorias.index');
    Route::post('/auditorias', [AuditoriaController::class, 'store'])->name('auditorias.store');
    Route::get('/auditoria/ver/{id}', [AuditoriaController::class, 'ver'])->name('auditoria.ver');
    Route::get('/auditorias/{id}', [AuditoriaController::class, 'show'])->name('auditorias.show');

    // DSAR
    Route::post('/dsar', [SolicitudDsarController::class, 'store'])->name('dsar.store');
    Route::put('/dsar/{id}', [SolicitudDsarController::class, 'update'])->name('dsar.update');
    Route::delete('/dsar/{id}', [SolicitudDsarController::class, 'destroy'])->name('dsar.destroy');
    Route::put('/dsar/{id}/estado', [SolicitudDsarController::class, 'cambiarEstado'])->name('dsar.estado');

    // MIEMBROS
    Route::get('/miembros', [MiembroController::class, 'index'])->name('miembros.index');
    Route::post('/miembros', [MiembroController::class, 'store'])->name('miembros.store');
    Route::put('/miembros/{id}', [MiembroController::class, 'update'])->name('miembros.update');
    Route::delete('/miembros/{id}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
    Route::put('/miembros/{id}/estado', [MiembroController::class, 'cambiarEstado'])->name('miembros.estado');
});
