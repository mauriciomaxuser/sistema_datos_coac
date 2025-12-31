<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SujetoDatoController;
use App\Http\Controllers\ProductoFinancieroController;
use App\Http\Controllers\ConsentimientoController;
use App\http\Controllers\ActividadProcesamientoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\IncidenteSeguridadController;
// rutas de usuarios y la que define el index ------------
Route::get('/', [UsuarioController::class, 'index'])->name('index');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
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

Route::get('/auditorias', [AuditoriaController::class, 'index'])->name('auditorias.index');
Route::post('/auditorias', [AuditoriaController::class, 'store'])->name('auditorias.store');
Route::get('/verificar-vista', function() {
    $ruta = resource_path('views/auditorias/show.blade.php');  
    if (file_exists($ruta)) {
        return "✅ El archivo EXISTE en: " . $ruta;
    } else {
        return "❌ El archivo NO existe. Búscalo en: " . $ruta;
    }
});