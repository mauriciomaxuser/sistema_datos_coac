<?php

namespace App\Http\Controllers;

use App\Models\SolicitudDsar;
use App\Models\SujetoDato;
use Illuminate\Http\Request;

class SolicitudDsarController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudDsar::with('sujeto')->orderBy('id','desc')->get();

        return view('index', compact('solicitudes'));
    }

    public function store(Request $request)
    {
        $sujeto = SujetoDato::where('cedula', $request->cedula)->first();

        if (!$sujeto) {
            return back()->withErrors(['cedula' => 'La cédula no existe'])->withInput();
        }

        SolicitudDsar::create([
            'numero_solicitud' => $request->numero_solicitud,
            'sujeto_id'        => $sujeto->id,
            'tipo'             => $request->tipo,
            'descripcion'      => $request->descripcion,
            'fecha_solicitud'  => $request->fecha_solicitud,
            'fecha_limite'     => $request->fecha_limite,
            'estado'           => $request->estado,
        ]);

        return redirect()->route('index')->with('swal', [
        'icon' => 'success',
        'title' => 'Solicitud DSAR',
        'text' => 'La solicitud se guardó correctamente'
    ]);

    }

    public function update(Request $request, $id)
    {
        $dsar = SolicitudDsar::findOrFail($id);

        $sujeto = SujetoDato::where('cedula', $request->cedula)->first();
        if (!$sujeto) {
            return back()->withErrors(['cedula' => 'La cédula no existe']);
        }

        $dsar->update([
            'numero_solicitud' => $request->numero_solicitud,
            'sujeto_id'        => $sujeto->id,
            'tipo'             => $request->tipo,
            'descripcion'      => $request->descripcion,
            'fecha_solicitud'  => $request->fecha_solicitud,
            'fecha_limite'     => $request->fecha_limite,
            'estado'           => $request->estado,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        SolicitudDsar::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function cambiarEstado(Request $request, $id)
    {
        $dsar = SolicitudDsar::findOrFail($id);
        $dsar->estado = $request->estado;
        $dsar->save();

        return redirect()->back();
    }
}

