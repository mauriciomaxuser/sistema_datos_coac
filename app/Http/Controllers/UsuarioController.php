<?php

namespace App\Http\Controllers;
use App\Models\Usuario; 
use App\Models\SujetoDato;
use App\Models\MiembroCoac;
use App\Models\ProductoFinanciero;
use App\Models\Consentimiento;
use App\Models\SolicitudDsar;
use App\Models\IncidenteSeguridad;
use App\Models\ActividadProcesamiento;
use App\Models\Auditoria;
use App\Models\Reporte;


use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('id')->get();
        $sujetos = SujetoDato::orderBy('id')->get();
        $miembros = MiembroCoac::orderBy('id')->get();
        $productos = ProductoFinanciero::orderBy('id')->get();
        $consentimientos = Consentimiento::orderBy('id')->get();
        $dsars = SolicitudDsar::orderBy('id')->get();
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        $procesamientos = ActividadProcesamiento::orderBy('id')->get();
        $auditorias = Auditoria::orderBy('id')->get();
        $reportes = Reporte::orderBy('id')->get();

        return view('index', compact('usuarios','sujetos','miembros','productos','consentimientos','dsars','incidentes','procesamientos',
            'auditorias',
            'reportes'
        ));
    }

    public function cambiarEstado($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->estado = $usuario->estado === 'activo'
            ? 'inactivo'
            : 'activo';

        $usuario->save();

        return redirect()->back()->with('success', 'Estado actualizado');
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
            'nombre_completo' => 'required|string|max:150',
            'email' => 'required|email|',
            'rol' => 'required'
        ]);

        Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'rol' => $request->rol,
            'estado' => 'activo'
        ]);

        return redirect()->back();

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        $usuario->save();

        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect('/')->with('success', 'Usuario eliminado correctamente');
    }
}
