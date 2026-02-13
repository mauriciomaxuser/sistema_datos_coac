<?php

namespace App\Http\Controllers;

use App\Models\ActividadProcesamiento;
use App\Models\MiembroCoac;
use App\Models\Usuario;
use App\Models\SujetoDato;
use App\Models\Auditoria;
use App\Models\Consentimiento;
use App\Models\IncidenteSeguridad;
use App\Models\ProductoFinanciero;
use App\Models\Reporte;
use App\Models\SolicitudDsar;
use Illuminate\Http\Request;

class ActividadProcesamientoController extends Controller
{
    //  Mostrar módulo procesamiento
    public function index()
    {
        $procesamientos = ActividadProcesamiento::all();
        $miembros = MiembroCoac::where('estado', 'activo')->get();
        $usuarios = Usuario::all();
        $sujetos = SujetoDato::all();
        $productos = ProductoFinanciero::all();
        $auditorias = Auditoria::all();
        $consentimientos = Consentimiento::all();
        $incidentes = IncidenteSeguridad::all();
        $reportes = Reporte::all();
        $dsars = SolicitudDsar::all();

        return view('index', compact('procesamientos', 'miembros', 'usuarios', 'sujetos', 'productos',
                    'auditorias', 'consentimientos', 'incidentes', 'reportes', 'dsars'));
    }

    //  Guardar nueva actividad
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|string|max:150',
                'responsable' => 'required|string|max:150',
                'finalidad' => 'required|string',
                'base_legal' => 'required|string',
            ],
            [
                'nombre.required' => 'El nombre de la actividad es obligatorio.',
                'nombre.max' => 'El nombre no puede tener más de 150 caracteres.',

                'responsable.required' => 'El responsable es obligatorio.',
                'responsable.max' => 'El responsable no puede tener más de 150 caracteres.',

                'finalidad.required' => 'La finalidad del tratamiento es obligatoria.',

                'base_legal.required' => 'Debe seleccionar una base legal.',
            ]
        );

        //  Generar código automático: RAT + AÑO + correlativo
        $anioActual = date('Y');

        $ultimoRegistro = ActividadProcesamiento::where('codigo', 'like', 'RAT' . $anioActual . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimoRegistro) {
            $numero = (int) substr($ultimoRegistro->codigo, -3);
            $nuevoNumero = $numero + 1;
        } else {
            $nuevoNumero = 1;
        }

        $codigoGenerado = 'RAT' . $anioActual . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);

        ActividadProcesamiento::create([
            'codigo' => $codigoGenerado,
            'nombre' => $request->nombre,
            'responsable' => $request->responsable,
            'finalidad' => $request->finalidad,
            'base_legal' => $request->base_legal,
            'categorias_datos' => $request->categorias_datos,
            'plazo_conservacion' => $request->plazo_conservacion,
            'medidas_seguridad' => $request->medidas_seguridad,
            'estado' => 'activo',
        ]);

        return redirect()->route('actividades.index')
            ->with('success', 'Actividad registrada correctamente.');
    }

    //  Ver actividad (para tu panel)
    public function ver($id)
    {
        $actividad = ActividadProcesamiento::findOrFail($id);
        return response()->json($actividad);
    }
}
