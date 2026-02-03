<?php

namespace App\Http\Controllers;

use App\Models\MiembroCoac;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MiembroController extends Controller
{
    public function index()
    {
        $miembros = MiembroCoac::orderBy('id', 'desc')->get();
        return view('tu_vista', compact('miembros')); // ajusta si tu vista tiene otro nombre
    }

    /**
     * REGISTRAR MIEMBRO
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => [
                'required',
                'string',
                'max:20',
                'unique:miembros_coac,cedula'
            ],
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'fecha_ingreso' => [
                'required',
                'date',
                'after_or_equal:1920-01-01',
                'before_or_equal:today'
            ],
            'categoria' => ['required', Rule::in(['activo', 'inactivo', 'honorario'])],
            'aportacion' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ], [
            'cedula.unique' => 'Ya existe un miembro con ese número de cédula.',
            'cedula.required' => 'La cédula es obligatoria.',
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.after_or_equal' => 'La fecha debe ser desde 1920 en adelante.',
            'fecha_ingreso.before_or_equal' => 'La fecha no puede ser mayor a hoy.',
            'categoria.required' => 'Seleccione una categoría.',
            'aportacion.max' => 'La aportación no puede superar 10.000.',
        ]);

        // Generar número de socio automáticamente (numérico)
        $ultimoNumero = MiembroCoac::max('numero_socio');
        $nuevoNumero = $ultimoNumero ? ((int)$ultimoNumero + 1) : 1;

        MiembroCoac::create([
            'numero_socio'    => $nuevoNumero,
            'cedula'          => $request->cedula,
            'nombre_completo' => trim($request->nombres . ' ' . $request->apellidos),
            'fecha_ingreso'   => $request->fecha_ingreso,
            'categoria'       => $request->categoria,
            'aportacion'      => $request->aportacion ?? 0.00,
            'estado'          => 'vigente'
        ]);

        return redirect()->back()->with('success', 'Miembro registrado correctamente');
    }

    /**
     * ACTUALIZAR MIEMBRO
     * - NO permite cambiar la cédula (se ignora)
     */
    public function update(Request $request, $id)
    {
        // OJO: cedula NO se valida ni se actualiza (queda fija)
        $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'fecha_ingreso' => [
                'required',
                'date',
                'after_or_equal:1920-01-01',
                'before_or_equal:today'
            ],
            'categoria' => ['required', Rule::in(['activo', 'inactivo', 'honorario'])],
            'aportacion' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ], [
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.after_or_equal' => 'La fecha debe ser desde 1920 en adelante.',
            'fecha_ingreso.before_or_equal' => 'La fecha no puede ser mayor a hoy.',
            'categoria.required' => 'Seleccione una categoría.',
            'aportacion.max' => 'La aportación no puede superar 10.000.',
        ]);

        $miembro = MiembroCoac::findOrFail($id);

        // NO se toca numero_socio NI cedula
        $miembro->update([
            'nombre_completo' => trim($request->nombres . ' ' . $request->apellidos),
            'fecha_ingreso'   => $request->fecha_ingreso,
            'categoria'       => $request->categoria,
            'aportacion'      => $request->aportacion ?? 0.00,
        ]);

        return redirect()->back()->with('success', 'Miembro actualizado correctamente');
    }

    /**
     * CAMBIAR ESTADO
     */
    public function cambiarEstado($id)
    {
        $miembro = MiembroCoac::findOrFail($id);

        $miembro->estado = ($miembro->estado === 'vigente') ? 'inactivo' : 'vigente';
        $miembro->save();

        return redirect()->back()->with('success', 'Estado del miembro actualizado');
    }
}
