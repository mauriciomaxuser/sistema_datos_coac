<?php

namespace App\Http\Controllers;

// nuevo para el correo 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificarCorreoUsuario;
//-------------------------------

use App\Models\Usuario; 
use App\Models\SujetoDato;
use App\Models\MiembroCoac;
use App\Models\ProductoFinanciero;
use App\Models\Consentimiento;
use App\Models\SolicitudDsar;
use App\Models\IncidenteSeguridad;
use App\Models\ActividadProcesamiento;
use App\Models\Auditoria;
use App\Models\Reporte;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::where('verificado', true)->orderBy('id')->get();
        $sujetos = SujetoDato::orderBy('id')->get();
        $miembros = MiembroCoac::orderBy('id')->get();
        $productos = ProductoFinanciero::orderBy('id')->get();
        $consentimientos = Consentimiento::orderBy('id')->get();
        $dsars = SolicitudDsar::orderBy('id')->get();
        $incidentes = IncidenteSeguridad::orderBy('id')->get();
        $procesamientos = ActividadProcesamiento::orderBy('id')->get();
        $auditorias = Auditoria::orderBy('id')->paginate(10);
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

        return view('index', compact(
            'usuarios', 'sujetos', 'miembros', 'productos', 'consentimientos',
            'dsars', 'incidentes', 'procesamientos', 'auditorias', 'reportes',
            'kpi_total_sujetos', 'kpi_consentimientos_activos', 'kpi_total_dsar',
            'kpi_incidentes_abiertos', 'kpi_dsar_por_tipo', 'kpi_incidentes_por_severidad'
        ));
    }

    public function cambiarEstado($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->estado = $usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $usuario->save();

        return redirect()->back()->with('success', 'Estado actualizado');
    }

    public function store(Request $request)
{
    $request->validate([
    'nombre'    => 'required|string|max:100',
    'apellido'  => 'required|string|max:100',
    'email'     => 'required|email|unique:usuarios,email',
    'cedula'    => [
        'required',
        'digits:10',
        function ($attribute, $value, $fail) {

            $existe = Usuario::where('cedula', $value)->exists()
                || SujetoDato::where('cedula', $value)->exists()
                || MiembroCoac::where('cedula', $value)->exists();

            if ($existe) {
                $fail('La cédula ya está registrada en el sistema.');
            }
        },
    ],
    'provincia' => 'nullable|string|max:100',
    'ciudad'    => 'nullable|string|max:100',
    'direccion' => 'nullable|string|max:255',
    'rol'       => 'required|string|max:50'
]);


    // Generar token de verificación
    $token = Str::random(64);
    
    $usuario = Usuario::create([
        'nombre'    => $request->nombre,
        'apellido'  => $request->apellido,
        'email'     => $request->email,
        'cedula'    => $request->cedula,
        'provincia' => $request->provincia,
        'ciudad'    => $request->ciudad,
        'direccion' => $request->direccion,
        'rol'       => $request->rol,
        'estado'    => 'inactivo',          // INACTIVO hasta verificar correo
        'email_verificado' => false,
        'verificado' => false,
        'email_verificacion_token' => $token,
        'password'  => Hash::make('123456'), // password temporal
    ]);

    try {
        // Enviar correo en segundo plano (cola)
        Mail::to($usuario->email)->queue(new VerificarCorreoUsuario($usuario));
    } catch (\Exception $e) {
        // Registrar el error, pero no bloquear la creación del usuario
        \Log::error('Error enviando correo de verificación: '.$e->getMessage());
    }

    return redirect()->back()
        ->with('success', 'Usuario registrado correctamente. Por favor verifica tu correo para activarlo.');
}



    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
        'nombre'    => 'required|string|max:100',
        'apellido'  => 'required|string|max:100',
        'email'     => 'required|email|unique:usuarios,email,' . $usuario->id . ',id',
        'cedula'    => [
            'required',
            'digits:10',
            function ($attribute, $value, $fail) use ($usuario) {

                // Validar que la cédula NO exista en ninguna de las tres tablas
                $existe = Usuario::where('cedula', $value)
                        ->where('id', '!=', $usuario->id)
                        ->exists()
                    || SujetoDato::where('cedula', $value)->exists()
                    || MiembroCoac::where('cedula', $value)->exists();

                if ($existe) {
                    $fail('La cédula ya está registrada en el sistema.');
                }
            },
        ],
        'provincia' => 'nullable|string|max:100',
        'ciudad'    => 'nullable|string|max:100',
        'direccion' => 'nullable|string|max:255',
        'rol'       => 'required|string|max:50'
    ]);

        $usuario->update([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'email'     => $request->email,
            'cedula'    => $request->cedula,
            'provincia' => $request->provincia,
            'ciudad'    => $request->ciudad,
            'direccion' => $request->direccion,
            'rol'       => $request->rol,
        ]);

        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }

    // Validación remota AJAX
   public function verificarEmail(Request $request)
{
    $email = $request->email;
    $id = $request->id_usuario;

    $query = Usuario::where('email', $email);

    if (!empty($id)) {
        $query->where('id', '!=', (int)$id);
    }

    $existe = $query->exists();

    return response()->json(!$existe);
}



    



    public function verificarNombre(Request $request)
    {
        $nombre = $request->nombre_completo;
        $id = $request->id;

        $existe = Usuario::whereRaw('LOWER(nombre_completo) = ?', [strtolower($nombre)])
            ->when($id, fn($q) => $q->where('id', '!=', $id))
            ->exists();

        return response()->json(!$existe);
    }

    public function verificarCedula(Request $request)
    {
        $cedula = $request->cedula;
        $id = $request->id;

        $existe = Usuario::where('cedula', $cedula)
                ->when($id, fn ($q) => $q->where('id', '!=', $id))
                ->exists()
            || SujetoDato::where('cedula', $cedula)->exists()
            || MiembroCoac::where('cedula', $cedula)->exists();

        return response()->json(!$existe);
    }

        public function verificarCorreo($token)
    {
        $usuario = Usuario::where('email_verificacion_token', $token)->firstOrFail();

        $usuario->email_verificado = true;
        $usuario->verificado = true;
        $usuario->estado = 'activo';
        $usuario->email_verificacion_token = null;
        $usuario->save();

return "Correo verificado correctamente. Cuenta activada.";
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
