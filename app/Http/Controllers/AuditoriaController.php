<?php

namespace App\Http\Controllers;
use App\Models\Auditoria;

use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    // LISTAR auditorías
    public function index()
    {
        $auditorias = Auditoria::orderBy('id', 'desc')->get();
        return view('auditorias.index', compact('auditorias'));
    }

    // GUARDAR auditoría
    public function store(Request $request)
    {
        Auditoria::create([
            'codigo'        => $request->codigo,
            'tipo'          => $request->tipo,
            'auditor'       => $request->auditor,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_fin'     => $request->fecha_fin,
            'estado'        => $request->estado,
            'alcance'       => $request->alcance,
            'hallazgos'     => $request->hallazgos,
        ]);

        return redirect()->back()->with('success', 'Auditoría registrada correctamente');
    }

    // VER auditoría
    public function ver($id)
    {
        $auditoria = Auditoria::findOrFail($id);
        return view('auditorias.ver', compact('auditoria'));

    /**
     * Display a listing of the resource.
     */
    }


}