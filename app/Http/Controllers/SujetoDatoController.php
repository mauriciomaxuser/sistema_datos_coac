<?php

namespace App\Http\Controllers;
use App\Models\SujetoDato;


use Illuminate\Http\Request;

class SujetoDatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sujetos = SujetoDato::orderBy('id')->get();
        return view('index', compact('usuarios','sujetos'));

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
            'cedula' => 'required|unique:sujetos_datos,cedula',
            'nombre' => 'required',
            'tipo' => 'required'
        ], [
        'cedula.unique' => 'La cédula ya existe en el sistema'
        ]); 

        SujetoDato::create([
            'cedula' => $request->cedula,
            'nombre_completo' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'tipo' => $request->tipo,
        ]);

        return redirect('/')->with('success', 'Sujeto registrado');
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
        $sujeto = SujetoDato::findOrFail($id);

        $sujeto->cedula = $request->cedula;
        $sujeto->nombre_completo = $request->nombre;
        $sujeto->email = $request->email;
        $sujeto->telefono = $request->telefono;
        $sujeto->direccion = $request->direccion;
        $sujeto->tipo = $request->tipo;

        $sujeto->save();

        return redirect()->back()->with('success', 'Sujeto actualizado');
    }


    public function destroy($id)
    {
        SujetoDato::findOrFail($id)->delete();
        return redirect('/');
    }

}
