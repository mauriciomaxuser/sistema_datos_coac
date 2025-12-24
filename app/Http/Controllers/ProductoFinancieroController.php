<?php

namespace App\Http\Controllers;

use App\Models\ProductoFinanciero;
use Illuminate\Http\Request;

class ProductoFinancieroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos_financieros,codigo',
            'nombre' => 'required|string|max:150',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'datos_procesados' => 'nullable|string',
        ]);

        ProductoFinanciero::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'datos_procesados' => $request->datos_procesados,
            'estado' => 'activo',
        ]);

        return redirect()->back()->with('success', 'Producto registrado correctamente');
    }

    public function update(Request $request, $id)
    {
        $producto = ProductoFinanciero::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos_financieros,codigo,' . $producto->id,
            'nombre' => 'required|string|max:150',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'datos_procesados' => 'nullable|string',
        ]);

        $producto->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'datos_procesados' => $request->datos_procesados,
        ]);

        return redirect()->back()->with('success', 'Producto actualizado correctamente');
    }

    public function cambiarEstado($id)
    {
        $producto = ProductoFinanciero::findOrFail($id);
        $producto->estado = $producto->estado === 'activo' ? 'inactivo' : 'activo';
        $producto->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = ProductoFinanciero::findOrFail($id);
        $producto->delete();

        return redirect()->back()->with('success', 'Producto eliminado correctamente');
    }
}