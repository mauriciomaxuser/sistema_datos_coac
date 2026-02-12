<?php

namespace App\Http\Controllers;

use App\Models\MiembroCoac;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MiembroController extends Controller
{
    public function index()
    {
        $miembros = MiembroCoac::orderBy('id', 'asc')->get();
        return view('tu_vista', compact('miembros')); // cambia tu_vista si tu blade se llama distinto
    }

    // ==========================
    // REGISTRAR
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => ['required', 'string', 'max:20', 'unique:miembros_coac,cedula'],
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'fecha_ingreso' => [
                'required',
                'date',
                'after_or_equal:1920-01-01',
                'before_or_equal:now'
            ],
            'categoria' => ['required', Rule::in(['activo', 'inactivo', 'honorario'])],
            'aportacion' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ], [
            'cedula.unique' => 'Ya existe un miembro con ese número de cédula.',
        ]);

        $ultimoNumero = MiembroCoac::max('numero_socio');
        $nuevoNumero = $ultimoNumero ? ((int)$ultimoNumero + 1) : 1;

        $nombreCompleto = trim($request->nombres . ' ' . $request->apellidos);

        MiembroCoac::create([
            'numero_socio'     => (string)$nuevoNumero,
            'cedula'           => $request->cedula,
            'nombre_completo'  => $nombreCompleto,
            'fecha_ingreso'    => $request->fecha_ingreso, // datetime
            'categoria'        => $request->categoria,
            'aportacion'       => $request->aportacion ?? 0.00,
            'estado'           => 'vigente',
        ]);

        return redirect()->back()->with('success', 'Miembro registrado correctamente');
    }

    // ==========================
    // ACTUALIZAR (NO editar cédula)
    // ==========================
    public function update(Request $request, $id)
    {
        $miembro = MiembroCoac::findOrFail($id);

        $request->validate([
            // cedula NO se valida porque NO se edita
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'fecha_ingreso' => [
                'required',
                'date',
                'after_or_equal:1920-01-01',
                'before_or_equal:now'
            ],
            'categoria' => ['required', Rule::in(['activo', 'inactivo', 'honorario'])],
            'aportacion' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ]);

        $nombreCompleto = trim($request->nombres . ' ' . $request->apellidos);

        $miembro->update([
            'nombre_completo' => $nombreCompleto,
            'fecha_ingreso'   => $request->fecha_ingreso,
            'categoria'       => $request->categoria,
            'aportacion'      => $request->aportacion ?? 0.00,
        ]);

        return redirect()->back()->with('success', 'Miembro actualizado correctamente');
    }

    // ==========================
    // CAMBIAR ESTADO
    // ==========================
    public function cambiarEstado($id)
    {
        $miembro = MiembroCoac::findOrFail($id);

        $miembro->estado = ($miembro->estado === 'vigente') ? 'inactivo' : 'vigente';
        $miembro->save();

        return redirect()->back()->with('success', 'Estado del miembro actualizado');
    }
    public function buscarCedulaExterna($cedula)
    {
        // Validación básica
        if(strlen($cedula) !== 10 || !is_numeric($cedula)){
            return response()->json(['error' => 'Cédula inválida'], 422);
        }

        try {
            // Consulta al Registro Civil
            $response = Http::asForm()->post('https://si.secap.gob.ec/sisecap/logeo_web/json/busca_persona_registro_civil.php', [
                'documento' => $cedula,
                'tipo' => '1'
            ]);

            if($response->failed()){
                return response()->json(['error' => 'Error al consultar cédula'], 500);
            }

            $data = $response->json();

            if(isset($data['nombres']) && isset($data['apellidos'])){
                return response()->json([
                    'nombres' => $data['nombres'],
                    'apellidos' => $data['apellidos']
                ]);
            } else {
                return response()->json(['error' => 'Datos no encontrados'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Excepción: '.$e->getMessage()], 500);
        }
    }
}
