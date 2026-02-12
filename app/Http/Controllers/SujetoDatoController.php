<?php

namespace App\Http\Controllers;

use App\Models\SujetoDato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Usuario;
use App\Models\MiembroCoac;



class SujetoDatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sujetos = SujetoDato::orderBy('id')->get();
        return view('index', compact('sujetos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
    'cedula' => [
        'required',
        'digits:10',
        function ($attribute, $value, $fail) {
            $existe = SujetoDato::where('cedula', $value)->exists()
                || Usuario::where('cedula', $value)->exists()
                || MiembroCoac::where('cedula', $value)->exists();

            if ($existe) {
                $fail('La cédula ya está registrada en el sistema.');
            }
        },
    ],
    'nombre' => 'required|string|max:100',
    'apellido' => 'required|string|max:100',
    'tipo' => 'required|string|max:50',
    'email' => 'required|email|unique:sujetos_datos,email',
    'telefono' => 'nullable|string|max:20',
    'direccion' => 'nullable|string|max:200',
    'ciudad' => 'nullable|string|max:100',
    'provincia' => 'required|string|max:100',
]);


        SujetoDato::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'tipo' => $request->tipo,
            'provincia' => $request->provincia,
        ]);

        return redirect('/')->with('success', 'Sujeto registrado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sujeto = SujetoDato::findOrFail($id);

        $request->validate([
    'cedula' => [
        'required',
        'digits:10',
        function ($attribute, $value, $fail) use ($id) {
            $existe = SujetoDato::where('cedula', $value)
                        ->where('id', '!=', $id)
                        ->exists()
                    || Usuario::where('cedula', $value)->exists()
                    || MiembroCoac::where('cedula', $value)->exists();

            if ($existe) {
                $fail('La cédula ya está registrada en el sistema.');
            }
        },
    ],
    'nombre' => 'required|string|max:100',
    'apellido' => 'required|string|max:100',
    'tipo' => 'required|string|max:50',
    'email' => "required|email|unique:sujetos_datos,email,$id",
    'telefono' => 'nullable|string|max:20',
    'direccion' => 'nullable|string|max:200',
    'ciudad' => 'nullable|string|max:100',
    'provincia' => 'required|string|max:100',
]);


        $sujeto->update([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'tipo' => $request->tipo,
            'provincia' => $request->provincia,
        ]);

        return redirect()->back()->with('success', 'Sujeto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        SujetoDato::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Sujeto eliminado correctamente');
    }

    /**
     * Verificar si la cédula existe.
     */
    public function verificarCedula(Request $request)
{
    $cedula = $request->cedula;
    $id = $request->sujeto_id;

    $existe = SujetoDato::where('cedula', $cedula)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists()
            || Usuario::where('cedula', $cedula)->exists()
            || MiembroCoac::where('cedula', $cedula)->exists();

    return response()->json(!$existe);
}


    /**
     * Verificar si el email existe.
     */
    public function verificarEmail(Request $request)
    {
        $email = trim($request->email); // 🔹 eliminar espacios
        $id = $request->sujeto_id;

        if(empty($email)) {
            return response()->json(false); // 🔹 no permitir vacío
        }

        $existe = SujetoDato::where('email', $email)
            ->when($id, fn($query) => $query->where('id', '!=', $id))
            ->exists();

        return response()->json(!$existe); // 🔹 true si no existe, false si existe
    }
    

    public function buscarCedulaExterna($cedula)
    {
        // Validación básica
        if(strlen($cedula) !== 10 || !is_numeric($cedula)){
            return response()->json(['error' => 'Cédula inválida'], 422);
        }

        try {
            // Consulta al Registro Civil
            $response = Http::asForm()->post('https://si.secap.gob.ec/sisecap/logeo_web/json/busca_persona_registro_civil.php', [
                'documento' => $cedula,
                'tipo' => '1'
            ]);

            if($response->failed()){
                return response()->json(['error' => 'Error al consultar cédula'], 500);
            }

            $data = $response->json();

            if(isset($data['nombres']) && isset($data['apellidos'])){
                return response()->json([
                    'nombres' => $data['nombres'],
                    'apellidos' => $data['apellidos']
                ]);
            } else {
                return response()->json(['error' => 'Datos no encontrados'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Excepción: '.$e->getMessage()], 500);
        }
    }



}
