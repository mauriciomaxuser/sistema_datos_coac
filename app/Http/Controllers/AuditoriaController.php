<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Trae SOLO auditores internos y externos activos
        $usuarios = Usuario::whereIn('rol', ['auditor', 'auditor_interno', 'auditor_externo'])
                       ->where('estado', 'activo')
                       ->orderBy('nombre', 'asc')
                       ->get();

        // Traer auditorías con la relación del auditor
        $auditorias = Auditoria::with('usuarioAuditor')
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Pasar ambas a la vista
        return view('index', compact('auditorias', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ VALIDACIÓN SIN HORAS - SOLO LOS CAMPOS DEL FORMULARIO
            $validated = $request->validate([
                'tipo_aud' => 'required|in:interna,externa',
                'auditor_id' => 'required|exists:usuarios,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:today',
                'estado_aud' => 'required|in:planificada,proceso,completada,revisada,cancelada',
                'alcance' => 'nullable|string|max:1000',
                'hallazgos' => 'nullable|string|max:2000',
            ], [
                'tipo_aud.required' => 'El tipo de auditoría es obligatorio.',
                'tipo_aud.in' => 'El tipo de auditoría seleccionado no es válido.',
                'auditor_id.required' => 'El auditor responsable es obligatorio.',
                'auditor_id.exists' => 'El auditor seleccionado no existe en el sistema.',
                'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
                'fecha_inicio.date' => 'La fecha de inicio no tiene un formato válido.',
                'fecha_fin.required' => 'La fecha de finalización es obligatoria.',
                'fecha_fin.date' => 'La fecha de finalización no tiene un formato válido.',
                'fecha_fin.after' => 'La fecha de finalización debe ser posterior a hoy.',
                'estado_aud.required' => 'El estado de la auditoría es obligatorio.',
                'estado_aud.in' => 'El estado seleccionado no es válido.',
                'alcance.max' => 'El alcance no debe exceder los 1000 caracteres.',
                'hallazgos.max' => 'Los hallazgos no deben exceder los 2000 caracteres.',
            ]);
            
            $auditor = Usuario::find($validated['auditor_id']);
            $rolesPermitidos = ['auditor', 'auditor_interno', 'auditor_externo'];
            
            if (!in_array($auditor->rol, $rolesPermitidos)) {
                throw ValidationException::withMessages([
                    'auditor_id' => 'El usuario seleccionado no tiene un rol de auditor válido.',
                ]);
            }
            
            DB::beginTransaction();
            
            try {
                // Generar código único para la auditoría
                $codigo = $this->generarCodigoAuditoria($validated['tipo_aud']);
                
                // ✅ Crear la auditoría - SIN CAMPOS DE HORA
                $auditoria = Auditoria::create([
                    'codigo' => $codigo,
                    'tipo' => $validated['tipo_aud'],      // Mapeo: tipo_aud → tipo
                    'auditor_id' => $validated['auditor_id'],
                    'fecha_inicio' => $validated['fecha_inicio'],
                    'fecha_fin' => $validated['fecha_fin'],
                    'estado' => $validated['estado_aud'],  // Mapeo: estado_aud → estado
                    'alcance' => $validated['alcance'] ?? null,
                    'hallazgos' => $validated['hallazgos'] ?? null,
                    'creado_por' => auth()->id(),
                ]);
                
                DB::commit();
                
                return redirect()->route('auditorias.index')
                    ->with('success', 'Auditoría registrada exitosamente. Código: ' . $codigo);
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error al crear auditoría en transacción: ' . $e->getMessage());
                throw $e;
            }
            
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Por favor corrija los errores en el formulario.');
                
        } catch (\Exception $e) {
            Log::error('Error al crear auditoría: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar la auditoría: ' . $e->getMessage());
        }
    }


    public function show(string $id)
    {
        try {
            $auditoria = Auditoria::with(['usuarioAuditor', 'creadoPor'])
                ->findOrFail($id);
            
            return view('auditorias.show', compact('auditoria'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('auditorias.index')
                ->with('error', 'La auditoría solicitada no existe.');
                
        } catch (\Exception $e) {
            Log::error('Error al mostrar auditoría: ' . $e->getMessage());
            return redirect()->route('auditorias.index')
                ->with('error', 'Error al cargar los detalles de la auditoría.');
        }
    }

 
    public function update(Request $request, string $id)
    {
        try {
            $auditoria = Auditoria::findOrFail($id);
            
            $validated = $request->validate([
                'estado' => 'required|in:planificada,proceso,completada,revisada,cancelada',
                'alcance' => 'nullable|string|max:1000',
                'hallazgos' => 'nullable|string|max:2000',
                'fecha_fin' => 'nullable|date|after:today',
            ], [
                'estado.required' => 'El estado es obligatorio.',
                'estado.in' => 'El estado seleccionado no es válido.',
                'alcance.max' => 'El alcance no debe exceder los 1000 caracteres.',
                'hallazgos.max' => 'Los hallazgos no deben exceder los 2000 caracteres.',
                'fecha_fin.date' => 'La fecha de finalización no tiene un formato válido.',
                'fecha_fin.after' => 'La fecha de finalización debe ser posterior a hoy.',
            ]);
            
            DB::beginTransaction();
            
            try {
                $auditoria->update([
                    'estado' => $validated['estado'],
                    'alcance' => $validated['alcance'] ?? $auditoria->alcance,
                    'hallazgos' => $validated['hallazgos'] ?? $auditoria->hallazgos,
                    'fecha_fin' => $validated['fecha_fin'] ?? $auditoria->fecha_fin,
                    'actualizado_por' => auth()->id(),
                ]);
                
                DB::commit();
                
                return redirect()->route('auditorias.show', $auditoria->id)
                    ->with('success', 'Auditoría actualizada exitosamente.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error al actualizar auditoría en transacción: ' . $e->getMessage());
                throw $e;
            }
            
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Por favor corrija los errores en el formulario.');
                
        } catch (\Exception $e) {
            Log::error('Error al actualizar auditoría: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar la auditoría: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {
            $auditoria = Auditoria::findOrFail($id);
            
            if ($auditoria->estado !== 'planificada') {
                return redirect()->back()
                    ->with('error', 'Solo se pueden eliminar auditorías en estado "Planificada".');
            }
            
            DB::beginTransaction();
            
            try {
                $auditoria->delete();
                
                DB::commit();
                
                return redirect()->route('auditorias.index')
                    ->with('success', 'Auditoría eliminada exitosamente.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error al eliminar auditoría en transacción: ' . $e->getMessage());
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar auditoría: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al eliminar la auditoría: ' . $e->getMessage());
        }
    }


    private function generarCodigoAuditoria($tipo_aud)
    {
        $prefijo = strtoupper(substr($tipo_aud, 0, 1)); 
        $anio = date('Y');
        $mes = date('m');
        
        $contador = Auditoria::whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->count() + 1;
        
        return sprintf('AUD-%s%s%s-%04d', $prefijo, $anio, $mes, $contador);
    }
}