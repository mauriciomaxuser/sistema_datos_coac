<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncidenteSeguridad;

class IncidenteSeguridadController extends Controller
{
    public function index()
    {
        $incidentes = IncidenteSeguridad::orderBy('id')->get();

        return view('index', [
            'incidentes' => $incidentes,
            'section' => 'incidentes' // 👈 controla la vista
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:incidentes_seguridad,codigo',
            'fecha' => 'required',
            'severidad' => 'required|string|max:30',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50',
            'sujetos_afectados' => 'nullable|integer|min:0',
            'estado' => 'required|string|max:30',
        ]);

        $validated['sujetos_afectados'] = $validated['sujetos_afectados'] ?? 0;

        IncidenteSeguridad::create($validated);

        return redirect('/#incidentes')->with('success', 'Incidente registrado correctamente');

    }

    public function edit(string $id)
    {
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        $incidenteEditar = IncidenteSeguridad::findOrFail($id);

        return view('index', [
            'incidentes' => $incidentes,
            'incidenteEditar' => $incidenteEditar,
            'section' => 'incidentes'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $incidente = IncidenteSeguridad::findOrFail($id);

        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:incidentes_seguridad,codigo,' . $incidente->id,
            'fecha' => 'required',
            'severidad' => 'required|string|max:30',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|max:50',
            'sujetos_afectados' => 'nullable|integer|min:0',
            'estado' => 'required|string|max:30',
        ]);

        $validated['sujetos_afectados'] = $validated['sujetos_afectados'] ?? 0;

        $incidente->update($validated);

        return redirect('/#incidentes')->with('success', 'Incidente registrado correctamente');
    }

    public function destroy(string $id)
    {
        IncidenteSeguridad::findOrFail($id)->delete();

        return redirect('/#incidentes')->with('success', 'Incidente registrado correctamente');
    }
}
