<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SujetoDatoController;
use App\Http\Controllers\ProductoFinancieroController;
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

// rutas de Incidentes ---------------------------------
Route::post('/incidentes', [IncidenteSeguridadController::class, 'store'])->name('incidentes.store');
Route::put('/incidentes/{id}', [IncidenteSeguridadController::class, 'update'])->name('incidentes.update');
Route::delete('/incidentes/{id}', [IncidenteSeguridadController::class, 'destroy'])->name('incidentes.destroy');
Route::get('/incidentes/{id}/edit', [IncidenteSeguridadController::class, 'edit'])->name('incidentes.edit');
Route::get('/incidentes', [IncidenteSeguridadController::class, 'index'])->name('incidentes.index');