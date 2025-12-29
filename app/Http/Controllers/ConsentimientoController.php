<?php

namespace App\Http\Controllers;

use App\Models\Consentimiento;
use App\Models\SujetoDato;
use Illuminate\Http\Request;

class ConsentimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consentimientos = Consentimiento::orderBy('id')->get();
        return view('index', compact('consentimientos'));
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
            'sujeto_id' => 'required|exists:sujetos_datos,id',
            'proposito' => 'required|string|max:100',
            'estado' => 'required|string|in:otorgado,revocado,pendiente',
            'fecha_otorgamiento' => 'nullable|date',
            'metodo' => 'nullable|string|max:50',
            'fecha_expiracion' => 'nullable|date'
        ]);

        Consentimiento::create([
            'sujeto_id' => $request->sujeto_id,
            'proposito' => $request->proposito,
            'estado' => $request->estado,
            'fecha_otorgamiento' => $request->fecha_otorgamiento,
            'metodo' => $request->metodo,
            'fecha_expiracion' => $request->fecha_expiracion
        ]);

        return redirect()->back()->with('success', 'Consentimiento registrado correctamente');
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
        $consentimiento = Consentimiento::findOrFail($id);

        $request->validate([
            'sujeto_id' => 'required|exists:sujetos_datos,id',
            'proposito' => 'required|string|max:100',
            'estado' => 'required|string|in:otorgado,revocado,pendiente',
            'fecha_otorgamiento' => 'nullable|date',
            'metodo' => 'nullable|string|max:50',
            'fecha_expiracion' => 'nullable|date'
        ]);

        $consentimiento->update([
            'sujeto_id' => $request->sujeto_id,
            'proposito' => $request->proposito,
            'estado' => $request->estado,
            'fecha_otorgamiento' => $request->fecha_otorgamiento,
            'metodo' => $request->metodo,
            'fecha_expiracion' => $request->fecha_expiracion
        ]);

        return redirect()->back()->with('success', 'Consentimiento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $consentimiento = Consentimiento::findOrFail($id);
        $consentimiento->delete();

        return redirect()->back()->with('success', 'Consentimiento eliminado correctamente');
    }
}
