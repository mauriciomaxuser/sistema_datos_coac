<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    // LISTAR
    public function index()
    {
        $auditorias = Auditoria::orderBy('id', 'desc')->get();
        return view('auditorias.index', compact('auditoria'));
    }

    // VER DETALLE
public function show($id)
{
    $auditoria = Auditoria::find($id);
    
    if (!$auditoria) {
        return redirect()->route('auditorias.index')
            ->with('error', 'Auditoría no encontrada');
    }
    
    // RUTA ABSOLUTA a la vista
    $viewPath = resource_path('views/auditorias/show.blade.php');
    
    // Si no existe el archivo, lo creamos automáticamente
    if (!file_exists($viewPath)) {
        // Crea la carpeta si no existe
        if (!is_dir(resource_path('views/auditorias'))) {
            mkdir(resource_path('views/auditorias'), 0755, true);
        }

        
        // Crea el archivo
        file_put_contents($viewPath, $contenido);
    }
    
    // Ahora muestra la vista
    return view('auditorias.show', compact('auditoria'));
}

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'codigo_aud'   => 'required|max:50|unique:auditorias,codigo',
            'tipo_aud'     => 'required',
            'auditor'      => 'required|max:150',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date',
            'estado_aud'   => 'required',
        ]);

        Auditoria::create([
            'codigo'        => $request->codigo_aud,
            'tipo'          => $request->tipo_aud,
            'auditor'       => $request->auditor,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_fin'     => $request->fecha_fin,
            'estado'        => $request->estado_aud,
            'alcance'       => $request->alcance,
            'hallazgos'     => $request->hallazgos,
        ]);

        return redirect()->back()->with('success', 'Auditoría registrada correctamente');
    }
}