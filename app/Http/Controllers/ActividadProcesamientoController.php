<?php

namespace App\Http\Controllers;

use App\Models\ActividadProcesamiento;
use Illuminate\Http\Request;

class ActividadProcesamientoController extends Controller
{
    public function index()
    {
        $procesamientos = ActividadProcesamiento::orderBy('id', 'desc')->get();
        return view('actividades_procesamiento.index', compact('actividades'));
    }

    public function store(Request $request)
    {
        ActividadProcesamiento::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'responsable' => $request->responsable,
            'finalidad' => $request->finalidad,
            'base_legal' => $request->base_legal,
            'categorias_datos' => $request->categorias_datos,
            'plazo_conservacion' => $request->plazo_conservacion,
            'medidas_seguridad' => $request->medidas_seguridad,
        ]);

        return redirect('/')->with('success', 'Actividad registrada correctamente');
    }
}
