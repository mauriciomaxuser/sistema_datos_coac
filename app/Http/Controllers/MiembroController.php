<?php

namespace App\Http\Controllers;

use App\Models\MiembroCoac;
use Illuminate\Http\Request;

class MiembroController extends Controller
{
    // Mostrar la vista principal con todos los miembros
    public function index()
    {
        $miembros = MiembroCoac::all();
        return view('tu_vista', compact('miembros')); // Ajusta 'tu_vista' por el nombre de tu vista
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_socio' => 'required|unique:miembros_coac,numero_socio',
            'cedula' => 'required',
            'nombre_completo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'categoria' => 'required|in:activo,inactivo,honorario',
            'aportacion' => 'nullable|numeric|min:0'
        ]);

        MiembroCoac::create([
            'numero_socio' => $request->numero_socio,
            'cedula' => $request->cedula,
            'nombre_completo' => $request->nombre_completo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'categoria' => $request->categoria,
            'aportacion' => $request->aportacion ?? 0.00,
            'estado' => 'vigente'
        ]);

        return redirect()->back()->with('success', 'Miembro registrado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_socio' => 'required|unique:miembros_coac,numero_socio,' . $id,
            'cedula' => 'required',
            'nombre_completo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'categoria' => 'required|in:activo,inactivo,honorario',
            'aportacion' => 'nullable|numeric|min:0'
        ]);

        $miembro = MiembroCoac::findOrFail($id);
        
        $miembro->update([
            'numero_socio' => $request->numero_socio,
            'cedula' => $request->cedula,
            'nombre_completo' => $request->nombre_completo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'categoria' => $request->categoria,
            'aportacion' => $request->aportacion ?? 0.00,
        ]);

        return redirect()->back()->with('success', 'Miembro actualizado correctamente');
    }

    public function cambiarEstado($id)
    {
        $miembro = MiembroCoac::findOrFail($id);
        
        $miembro->estado = $miembro->estado === 'vigente'
            ? 'inactivo'
            : 'vigente';
            
        $miembro->save();

        return redirect()->back()->with('success', 'Estado del miembro actualizado');
    }

    public function destroy($id)
    {
        $miembro = MiembroCoac::findOrFail($id);
        $miembro->delete();

        return redirect()->back()->with('success', 'Miembro eliminado correctamente');
    }
}