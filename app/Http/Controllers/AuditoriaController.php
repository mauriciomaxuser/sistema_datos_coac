<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias = Auditoria::orderBy('id', 'desc')->paginate(10);
        return view('auditorias.index', compact('auditorias'));
    }

    public function show($id)
    {
        $auditoria = Auditoria::find($id);

        if (!$auditoria) {
            return redirect()->route('auditorias.index')
                ->with('error', 'Auditoría no encontrada');
        }

        return view('auditorias.show', compact('auditoria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_aud'     => 'required',
            'auditor'      => 'required|max:150',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date',
            'estado_aud'   => 'required',
            'alcance'      => 'nullable|string',
            'hallazgos'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $ultimoCodigo = Auditoria::lockForUpdate()->max('codigo');
            $nuevoCodigo = $ultimoCodigo ? $ultimoCodigo + 1 : 1;

            Auditoria::create([
                'codigo'        => $nuevoCodigo,
                'tipo'          => $request->tipo_aud,
                'auditor'       => $request->auditor,
                'fecha_inicio'  => $request->fecha_inicio,
                'fecha_fin'     => $request->fecha_fin,
                'estado'        => $request->estado_aud,
                'alcance'       => $request->alcance,
                'hallazgos'     => $request->hallazgos,
            ]);
        });

        return redirect()->back()->with('success', 'Auditoría registrada correctamente');
    }
}
