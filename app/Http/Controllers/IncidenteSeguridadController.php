<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncidenteSeguridad;

class IncidenteSeguridadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        return view('index', compact('incidentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:incidentes_seguridad,codigo',
            'fecha' => 'required|date',
            'severidad' => 'required|string|max:30',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50',
            'sujetos_afectados' => 'nullable|integer',
            'estado' => 'required|string|max:30',
        ]);

        IncidenteSeguridad::create($request->all());

        return redirect()->back()->with('success', 'Incidente registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        $incidenteEditar = IncidenteSeguridad::findOrFail($id);
        return view('index', compact('incidentes', 'incidenteEditar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $incidente = IncidenteSeguridad::findOrFail($id);

        $request->validate([
            'codigo' => 'required|unique:incidentes_seguridad,codigo,' . $incidente->id,
            'fecha' => 'required|date',
            'severidad' => 'required|string|max:30',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50',
            'sujetos_afectados' => 'nullable|integer',
            'estado' => 'required|string|max:30',
        ]);

        $incidente->update($request->all());

        return redirect()->back()->with('success', 'Incidente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        IncidenteSeguridad::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Incidente eliminado correctamente');
    }
}
