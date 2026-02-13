<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\SujetoDato;
use App\Models\Usuario;
use App\Models\MiembroCoac;
use App\Models\ProductoFinanciero;
use App\Models\Consentimiento;
use App\Models\SolicitudDsar;
use App\Models\IncidenteSeguridad;
use App\Models\ActividadProcesamiento;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::whereIn('rol', ['auditor', 'auditor_interno', 'auditor_externo'])
            ->where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        $auditorias = Auditoria::with('usuarioAuditor')
            ->orderBy('created_at', 'desc')
            ->get();

        // Traer todas las variables necesarias para la vista
        $sujetos = SujetoDato::orderBy('id')->get();
        $miembros = MiembroCoac::orderBy('id')->get();
        $productos = ProductoFinanciero::orderBy('id')->get();
        $consentimientos = Consentimiento::orderBy('id')->get();
        $dsars = SolicitudDsar::orderBy('id')->get();
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        $procesamientos = ActividadProcesamiento::orderBy('id')->get();
        $reportes = Reporte::orderBy('id')->get();

        // KPIs
        $kpi_total_sujetos = SujetoDato::count();
        $kpi_consentimientos_activos = Consentimiento::where('estado', 'otorgado')->count();
        $kpi_total_dsar = SolicitudDsar::count();
        $kpi_incidentes_abiertos = IncidenteSeguridad::where('estado', 'abierto')->count();
        $kpi_dsar_por_tipo = SolicitudDsar::select('tipo')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tipo')
            ->get();
        $kpi_incidentes_por_severidad = IncidenteSeguridad::select('severidad')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('severidad')
            ->get();

        // Pasar todas las variables a la vista
        return view('index', compact(
            'auditorias', 'usuarios', 'sujetos', 'miembros', 'productos', 
            'consentimientos', 'dsars', 'incidentes', 'procesamientos', 'reportes',
            'kpi_total_sujetos', 'kpi_consentimientos_activos', 'kpi_total_dsar',
            'kpi_incidentes_abiertos', 'kpi_dsar_por_tipo', 'kpi_incidentes_por_severidad'
        ));
    }

    public function store(Request $request)
    {
        try {

            // Convertir fecha
            if ($request->filled('fecha_fin')) {
                $request->merge([
                    'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)
                        ->format('Y-m-d')
                ]);
            }

            $validated = $request->validate([
                'tipo_aud' => 'required|in:interna,externa',
                'auditor_id' => 'required|exists:usuarios,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'estado_aud' => 'required|in:planificada,proceso,completada,revisada,cancelada',
                'alcance' => 'nullable|string|max:1000',
                'hallazgos' => 'nullable|string|max:2000',
            ]);

            DB::beginTransaction();

            $codigo = $this->generarCodigoAuditoria($validated['tipo_aud']);

            $auditoria = Auditoria::create([
                'codigo' => $codigo,
                'tipo' => $validated['tipo_aud'],
                'auditor_id' => $validated['auditor_id'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'estado' => $validated['estado_aud'],
                'alcance' => $validated['alcance'] ?? null,
                'hallazgos' => $validated['hallazgos'] ?? null,
                'creado_por' => auth()->id() ?? 1, // 🔴 fallback
            ]);

            DB::commit();

            return redirect()->route('auditorias.index')
                ->with('success', 'Auditoría registrada correctamente. Código: ' . $codigo);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR STORE AUDITORIA: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $auditoria = Auditoria::findOrFail($id);

            if ($request->filled('fecha_fin') && strpos($request->fecha_fin, '/') !== false) {
                $request->merge([
                    'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)
                        ->format('Y-m-d')
                ]);
            }

            $validated = $request->validate([
                'estado' => 'required|in:planificada,proceso,completada,revisada,cancelada',
                'alcance' => 'nullable|string|max:1000',
                'hallazgos' => 'nullable|string|max:2000',
                'fecha_fin' => 'nullable|date|after:' . $auditoria->fecha_inicio,
            ]);

            DB::beginTransaction();

            $auditoria->update([
                'estado' => $validated['estado'],
                'alcance' => $validated['alcance'] ?? $auditoria->alcance,
                'hallazgos' => $validated['hallazgos'] ?? $auditoria->hallazgos,
                'fecha_fin' => $validated['fecha_fin'] ?? $auditoria->fecha_fin,
                'actualizado_por' => auth()->id() ?? 1,
            ]);

            DB::commit();

            return redirect()->route('auditorias.show', $auditoria->id)
                ->with('success', 'Auditoría actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR UPDATE AUDITORIA: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $auditoria = Auditoria::findOrFail($id);

            if ($auditoria->estado !== 'planificada') {
                return redirect()->back()
                    ->with('error', 'Solo se pueden eliminar auditorías planificadas.');
            }

            $auditoria->delete();

            return redirect()->route('auditorias.index')
                ->with('success', 'Auditoría eliminada correctamente.');

        } catch (\Exception $e) {
            Log::error('ERROR DELETE AUDITORIA: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    private function generarCodigoAuditoria($tipo)
    {
        $prefijo = strtoupper(substr($tipo, 0, 1));
        $anio = date('Y');
        $mes = date('m');

        $ultimo = Auditoria::orderBy('id', 'desc')
            ->lockForUpdate()
            ->first();

        $numero = 1;

        if ($ultimo && preg_match('/-(\d{4})$/', $ultimo->codigo, $match)) {
            $numero = intval($match[1]) + 1;
        }

        return sprintf('AUD-%s%s%s-%04d', $prefijo, $anio, $mes, $numero);
    }
}
