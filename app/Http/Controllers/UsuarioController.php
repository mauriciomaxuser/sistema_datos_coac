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
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    
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
        $auditorias = Auditoria::orderBy('id')->paginate(10);

        $reportes = Reporte::orderBy('id')->get();

        $kpi_total_sujetos = SujetoDato::count();

        $kpi_consentimientos_activos = Consentimiento::where('estado', 'otorgado')->count();

        $kpi_total_dsar = SolicitudDsar::count();

        $kpi_incidentes_abiertos = IncidenteSeguridad::where('estado', 'abierto')->count();

        $kpi_dsar_por_tipo = SolicitudDsar::select('tipo')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tipo')
            ->get();

        // KPI 6: Incidentes por severidad
        $kpi_incidentes_por_severidad = IncidenteSeguridad::select('severidad')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('severidad')
            ->get();

        return view('index', compact(
            'usuarios',
            'sujetos',
            'miembros',
            'productos',
            'consentimientos',
            'dsars',
            'incidentes',
            'procesamientos',
            'auditorias',
            'reportes',

            // KPIs
            'kpi_total_sujetos',
            'kpi_consentimientos_activos',
            'kpi_total_dsar',
            'kpi_incidentes_abiertos',
            'kpi_dsar_por_tipo',
            'kpi_incidentes_por_severidad'
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

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'email' => 'required|email',
            'rol' => 'required'
        ]);

        Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'rol' => $request->rol,
            'estado' => 'activo',
            'password' => Hash::make('123456')
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        $usuario->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect('/')->with('success', 'Usuario eliminado correctamente');
    }
    public function verificarEmail(Request $request)
    {
        $email = $request->email;
        $id = $request->id;

        $existe = Usuario::where('email', $email)
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id); // 👈 excluye el mismo usuario
            })
            ->exists();

        return response()->json(!$existe);
    }


}
