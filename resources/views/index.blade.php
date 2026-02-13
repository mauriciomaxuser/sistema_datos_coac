<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Datos Personales - COAC</title>
    
    
    
    

    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <!-- jQuery  -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="{{ asset('scripts/scripts.js') }}"></script>

    

</head>

<style>
    .input-error {
    border: 1px solid #ef4444 !important;
    background: #fff5f5;
}

.text-error {
    color: #dc2626;
    font-size: 12px;
}
.logout-button {
    position: absolute; /* Posición fija respecto al body */
    top: 20px;          /* 20px desde arriba */
    right: 20px;        /* 20px desde la derecha */
}

</style>
<body>
    <!-- Botón de logout -->
    <form action="{{ route('logout') }}" method="POST" class="logout-button">
    @csrf
    <button type="submit" class="btn btn-danger">
        <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
    </button>
</form>

    
    <div class="container">
        <br>
        <br>
        <div class="header">
            <h1> Sistema de Gestión de Datos Personales</h1>
            <p>Cooperativa de Ahorro y Crédito - Protección de Datos</p>
        </div>
        
        <div class="nav-tabs">
            {{-- ADMIN --}}
    @if(auth()->user()->rol === 'admin')
        <button class="active" onclick="showSection('usuarios')">Usuarios</button>
        <button onclick="showSection('sujetos')">Sujetos</button>
        <button onclick="showSection('miembros')">Miembros</button>
        <button onclick="showSection('productos')">Productos</button>
        <button onclick="showSection('consentimientos')">Consentimientos</button>
        <button onclick="showSection('dsar')">DSAR</button>
        <button onclick="showSection('incidentes')">Incidentes</button>
        <button onclick="showSection('procesamiento')">Procesamiento</button>
        <button onclick="showSection('auditorias')">Auditorías</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- DPO --}}
    @elseif(auth()->user()->rol === 'dpo')
        <button class="active" onclick="showSection('sujetos')">Sujetos</button>
        <button onclick="showSection('consentimientos')">Consentimientos</button>
        <button onclick="showSection('dsar')">DSAR</button>
        <button onclick="showSection('incidentes')">Incidentes</button>
        <button onclick="showSection('procesamiento')">Procesamiento</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- AUDITOR --}}
    @elseif(auth()->user()->rol === 'auditor')
        <button class="active" onclick="showSection('auditorias')">Auditorías</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- OPERADOR --}}
    @elseif(auth()->user()->rol === 'operador')
        <button class="active" onclick="showSection('sujetos')">Sujetos</button>
        <button onclick="showSection('miembros')">Miembros</button>
        <button onclick="showSection('productos')">Productos</button>
        <button onclick="showSection('consentimientos')">Consentimientos</button>

    {{-- AUDITOR INTERNO --}}
    @elseif(auth()->user()->rol === 'auditor_interno')
        <button class="active" onclick="showSection('auditorias')">Auditorías</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- GESTOR DE CONSENTIMIENTOS --}}
    @elseif(auth()->user()->rol === 'gestor_consentimientos')
        <button class="active" onclick="showSection('sujetos')">Sujetos</button>
        <button onclick="showSection('consentimientos')">Consentimientos</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- GESTOR DE INCIDENTES --}}
    @elseif(auth()->user()->rol === 'gestor_incidentes')
        <button class="active" onclick="showSection('incidentes')">Incidentes</button>
        <button onclick="showSection('reportes')">Reportes</button>

    {{-- TITULAR --}}
    @elseif(auth()->user()->rol === 'titular')
        <button class="active" onclick="showSection('reportes')">Reportes</button>
    @endif
        </div>

        
        <!-- USUARIOS ----------------------------------------------------------------------------------------->
@if(auth()->user()->rol === 'admin')
<div id="usuarios" class="content-section active">
    <h2 class="section-title">Gestión de Usuarios del Sistema</h2>

    <form id="formUsuarios" method="POST" action="{{ url('/usuarios') }}">
        @csrf
        <input type="hidden" name="_method" id="form_method" value="POST">
        <input type="hidden" name="id_usuario" id="usuario_id">

        <div class="form-row">
            <div class="form-group">
                <label>Cédula *</label>
                <input type="text" name="cedula" id="cedula"
                       placeholder="Ingrese su número de cédula"
                       maxlength="10"
                       pattern="[0-9]{10}"
                       required>
            </div>

            <div class="form-group">
                <label>Nombres *</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombres" readonly>
            </div>

            <div class="form-group">
                <label>Apellidos *</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellidos" readonly>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" id="email" placeholder="Ingrese un correo electrónico">
            </div>
            <div class="form-group">
                <label>Provincia</label>
                <select name="provincia" id="provincia">
                    <option value="">Seleccionar...</option>
                    <option value="Azuay">Azuay</option>
                    <option value="Bolívar">Bolívar</option>
                    <option value="Cañar">Cañar</option>
                    <option value="Carchi">Carchi</option>
                    <option value="Chimborazo">Chimborazo</option>
                    <option value="Cotopaxi">Cotopaxi</option>
                    <option value="El Oro">El Oro</option>
                    <option value="Esmeraldas">Esmeraldas</option>
                    <option value="Galápagos">Galápagos</option>
                    <option value="Guayas">Guayas</option>
                    <option value="Imbabura">Imbabura</option>
                    <option value="Loja">Loja</option>
                    <option value="Los Ríos">Los Ríos</option>
                    <option value="Manabí">Manabí</option>
                    <option value="Morona Santiago">Morona Santiago</option>
                    <option value="Napo">Napo</option>
                    <option value="Orellana">Orellana</option>
                    <option value="Pastaza">Pastaza</option>
                    <option value="Pichincha">Pichincha</option>
                    <option value="Santa Elena">Santa Elena</option>
                    <option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
                    <option value="Sucumbíos">Sucumbíos</option>
                    <option value="Tungurahua">Tungurahua</option>
                    <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                </select>
            </div>


            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" id="ciudad" placeholder="Ej: Quito">
            </div>

            <div class="form-group">
                <label>Dirección/Referencia</label>
                <input type="text" name="direccion" id="direccion" placeholder="Ej: Calle 123">
            </div>

            <div class="form-group">
    <label>Rol *</label>
    <select name="rol" id="rol">
        <option value="">Seleccionar...</option>
        <option value="dpo">Oficial de Protección de Datos</option>
        <option value="operador">Operador</option>

        {{-- Mostrar "Auditor interno" solo si no existe ya --}}
        @if(!$usuarios->where('rol', 'auditor_interno')->count())
            <option value="auditor_interno">Auditor interno</option>
        @endif

        <option value="gestor_consentimientos">Gestor de consentimientos</option>
        <option value="gestor_incidentes">Gestor de incidentes</option>

        {{-- Mostrar "Titular" solo si no existe ya --}}
        @if(!$usuarios->where('rol', 'titular')->count())
            <option value="titular">Titular</option>
        @endif
    </select>
</div>
</div>
    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Email</th>
                    <th>Provincia</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->apellido }}</td>
                    <td>{{ $usuario->cedula }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->provincia }}</td>
                    <td>{{ $usuario->ciudad }}</td>
                    <td>{{ $usuario->direccion }}</td>
                    <td>{{ $usuario->rol_texto }}</td>
                    <td>
                        @if($usuario->estado === 'activo')
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        @if($usuario->rol !== 'admin')
                            <button class="btn btn-secondary"
                                onclick="editarUsuario(
                                    '{{ $usuario->id }}',
                                    '{{ $usuario->nombre }}',
                                    '{{ $usuario->apellido }}',
                                    '{{ $usuario->email }}',
                                    '{{ $usuario->cedula }}',
                                    '{{ $usuario->provincia }}',
                                    '{{ $usuario->ciudad }}',
                                    '{{ $usuario->direccion }}',
                                    '{{ $usuario->rol }}'
                                )">
                                Editar
                            </button>


                            <form action="{{ route('usuarios.estado', $usuario->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">Cambiar estado</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('cedula');
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');

    cedulaInput.addEventListener('blur', async () => {
        const cedula = cedulaInput.value.trim();

        if(cedula.length !== 10 || isNaN(cedula)) {
            nombreInput.value = '';
            apellidoInput.value = '';
            return;
        }

        try {
            const response = await fetch(`/api/cedula-externa/${cedula}`);
            if(!response.ok) throw new Error('Error en la consulta externa');

            const data = await response.json();

            if(data && data.nombres && data.apellidos) {
                nombreInput.value = data.nombres;
                apellidoInput.value = data.apellidos;
            } else {
                nombreInput.value = '';
                apellidoInput.value = '';
            }
        } catch (error) {
            console.error(error);
            nombreInput.value = '';
            apellidoInput.value = '';
        }
    });
});
</script>

@endif



<!-- SUJETOS DE DATOS -------------------------------------------------------------------------------->
<!-- ========================================= -->
@if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'dpo')
<div id="sujetos" class="content-section">
    <h2 class="section-title">Registro de Sujetos de Datos</h2>

    <!-- FORMULARIO DE SUJETOS -->
    <form id="formSujetos" method="POST" action="{{ route('sujetos.store') }}">
        @csrf
        <input type="hidden" name="_method" id="form_sujeto_method" value="POST">
        <input type="hidden" id="sujeto_id" name="sujeto_id">

        <!-- FILA 1 -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Cédula*</label>
                <input type="text" id="cedulaInput" name="cedula" required maxlength="10" pattern="\d{10}" title="Debe tener 10 dígitos">
            </div>
            <div class="form-group col-md-3">
                <label>Nombres*</label>
                <input type="text" id="nombreInput" name="nombre" required readonly>
            </div>
            <div class="form-group col-md-3">
                <label>Apellidos*</label>
                <input type="text" id="apellidoInput" name="apellido" required readonly>
            </div>
            <div class="form-group col-md-3">
                <label>Email</label>
                <input type="email" id="emailInput" name="email" required>
            </div>
        </div>

        <!-- FILA 2 -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Teléfono</label>
                <input type="tel" name="telefono" maxlength="10" pattern="\d{10}" title="Debe tener 10 dígitos" required>
            </div>
            <div class="form-group col-md-3">
                <label>Provincia*</label>
                <select name="provincia" required>
                    <option value="">Seleccionar...</option>
                    <option value="Azuay">Azuay</option>
                    <option value="Bolívar">Bolívar</option>
                    <option value="Cañar">Cañar</option>
                    <option value="Carchi">Carchi</option>
                    <option value="Chimborazo">Chimborazo</option>
                    <option value="Cotopaxi">Cotopaxi</option>
                    <option value="El Oro">El Oro</option>
                    <option value="Esmeraldas">Esmeraldas</option>
                    <option value="Galápagos">Galápagos</option>
                    <option value="Guayas">Guayas</option>
                    <option value="Imbabura">Imbabura</option>
                    <option value="Loja">Loja</option>
                    <option value="Los Ríos">Los Ríos</option>
                    <option value="Manabí">Manabí</option>
                    <option value="Morona Santiago">Morona Santiago</option>
                    <option value="Napo">Napo</option>
                    <option value="Orellana">Orellana</option>
                    <option value="Pastaza">Pastaza</option>
                    <option value="Pichincha">Pichincha</option>
                    <option value="Santa Elena">Santa Elena</option>
                    <option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
                    <option value="Sucumbíos">Sucumbíos</option>
                    <option value="Tungurahua">Tungurahua</option>
                    <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Ciudad</label>
                <input type="text" name="ciudad" required>
            </div>
            <div class="form-group col-md-3">
                <label>Dirección/Referencia</label>
                <input type="text" name="direccion" required>
            </div>
        </div>

        <!-- FILA 3 -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Tipo de Sujeto*</label>
                <select name="tipo" required>
                    <option value="">Seleccionar...</option>
                    <option value="cliente">Cliente</option>
                    <option value="empleado">Empleado</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="tercero">Tercero</option>
                </select>
            </div>
            </div>

            <div class="form-row">
            <div class="form-group col-12">
                <button type="submit" class="btn btn-primary">Registrar Sujeto</button>
            </div>
        </div>
    </form>

    <!-- TABLA DE SUJETOS -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                    <th>Provincia</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sujetos as $sujeto)
                <tr>
                    <td>{{ $sujeto->cedula }}</td>
                    <td>{{ $sujeto->nombre }}</td>
                    <td>{{ $sujeto->apellido }}</td>
                    <td>{{ $sujeto->email }}</td>
                    <td>{{ $sujeto->telefono }}</td>
                    <td>{{ $sujeto->ciudad }}</td>
                    <td>{{ $sujeto->direccion }}</td>
                    <td>{{ $sujeto->provincia }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($sujeto->tipo) }}</span></td>
                    <td>
                        <button class="btn btn-secondary"
                            onclick="editarSujeto(
                                {{ $sujeto->id }},
                                '{{ $sujeto->cedula }}',
                                '{{ $sujeto->nombre }}',
                                '{{ $sujeto->apellido }}',
                                '{{ $sujeto->email }}',
                                '{{ $sujeto->telefono }}',
                                '{{ $sujeto->direccion }}',
                                '{{ $sujeto->ciudad }}',
                                '{{ $sujeto->provincia }}',
                                '{{ $sujeto->tipo }}'
                            )">
                            Editar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('cedulaInput');
    const nombreInput = document.getElementById('nombreInput');
    const apellidoInput = document.getElementById('apellidoInput');

    cedulaInput.addEventListener('blur', async () => {
        const cedula = cedulaInput.value.trim();

        if(cedula.length !== 10 || isNaN(cedula)) {
            nombreInput.value = '';
            apellidoInput.value = '';
            return;
        }

        try {
            const response = await fetch(`/api/cedula-externa/${cedula}`);
            if(!response.ok) throw new Error('Error en la consulta externa');

            const data = await response.json();

            if(data && data.nombres && data.apellidos) {
                nombreInput.value = data.nombres;
                apellidoInput.value = data.apellidos;
            } else {
                nombreInput.value = '';
                apellidoInput.value = '';
            }
        } catch (error) {
            console.error(error);
            nombreInput.value = '';
            apellidoInput.value = '';
        }
    });
});

</script>
@endif

    
        
        <!-- MIEMBROS COAC -->
        <!-- MIEMBROS COAC -->
        <div id="miembros" class="content-section">
    <h2 class="section-title">Gestión de Miembros de la Cooperativa</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORMULARIO -->
    <form id="formMiembros" method="POST" action="{{ route('miembros.store') }}">
        @csrf
        <input type="hidden" name="_method" id="form_miembro_method" value="POST">
        <input type="hidden" name="id" id="miembro_id">

        <div class="form-row">
            <div class="form-group">
                <label>Cédula *</label>
                <input type="text" name="cedula" id="miembro_cedula" maxlength="10" pattern="\d{10}" required>
            </div>

            <div class="form-group">
                <label>Nombres *</label>
                <input type="text" name="nombres" id="miembro_nombres" readonly required>
            </div>

            <div class="form-group">
                <label>Apellidos *</label>
                <input type="text" name="apellidos" id="miembro_apellidos" readonly required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha y Hora de Ingreso *</label>
                <input type="datetime-local"
                       name="fecha_ingreso"
                       id="miembro_fecha_ingreso"
                       min="1920-01-01T00:00"
                       max="{{ now()->format('Y-m-d\TH:i') }}"
                       value="{{ old('fecha_ingreso', now()->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="form-group">
                <label>Estado *</label>
                <select name="categoria" id="miembro_categoria" required>
                    <option value="">Seleccionar...</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="honorario">Honorario</option>
                </select>
            </div>

            <div class="form-group">
                <label>Aportación Inicial (máx. 10.000)</label>
                <input type="number" name="aportacion" id="miembro_aportacion" step="0.01" min="0" max="10000" value="0">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="btnMiembroSubmit">Registrar Miembro</button>
        <button type="button" class="btn btn-secondary" onclick="resetFormularioMiembros()">Cancelar</button>
    </form>

    <!-- TABLA -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>N° Socio</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Fecha/Hora Ingreso</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($miembros as $miembro)
                <tr>
                    <td>{{ $miembro->numero_socio }}</td>
                    <td>{{ $miembro->cedula }}</td>
                    <td>{{ $miembro->nombre_completo }}</td>
                    <td>{{ \Carbon\Carbon::parse($miembro->fecha_ingreso)->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($miembro->categoria) }}</td>
                    <td>
                        @if($miembro->estado === 'vigente')
                            <span class="badge badge-success">Vigente</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-editar-miembro"
                                data-id="{{ $miembro->id }}"
                                data-cedula="{{ $miembro->cedula }}"
                                data-nombre="{{ $miembro->nombre_completo }}"
                                data-fecha="{{ \Carbon\Carbon::parse($miembro->fecha_ingreso)->format('Y-m-d\TH:i') }}"
                                data-categoria="{{ $miembro->categoria }}"
                                data-aportacion="{{ $miembro->aportacion ?? 0 }}">
                            Editar
                        </button>

                        <form action="{{ route('miembros.estado', $miembro->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Cambiar estado</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('miembro_cedula');
    const nombreInput = document.getElementById('miembro_nombres');
    const apellidoInput = document.getElementById('miembro_apellidos');

    cedulaInput.addEventListener('blur', async () => {
        const cedula = cedulaInput.value.trim();

        if(cedula.length !== 10 || isNaN(cedula)) {
            nombreInput.value = '';
            apellidoInput.value = '';
            return;
        }

        try {
            const response = await fetch(`/api/cedula-externa/${cedula}`);
            if(!response.ok) throw new Error('Error en la consulta externa');

            const data = await response.json();
            if(data && data.nombres && data.apellidos) {
                nombreInput.value = data.nombres;
                apellidoInput.value = data.apellidos;
            } else {
                nombreInput.value = '';
                apellidoInput.value = '';
            }
        } catch (error) {
            console.error(error);
            nombreInput.value = '';
            apellidoInput.value = '';
        }
    });
});
</script>



<!-- PRODUCTOS FINANCIEROS ------------------------------------------------------>
<div id="productos" class="content-section">
    <h2 class="section-title">Productos Financieros</h2>
    
    <form id="formProductos" method="POST" action="{{ route('productos.store') }}" novalidate>
        @csrf
        <input type="hidden" name="_method" id="form_producto_method" value="POST">
        <input type="hidden" name="id" id="producto_id">

        <div class="form-row">
            <div class="form-group">
                <label>Código Producto *</label>
                <div style="position: relative;">
                    <input type="text" name="codigo" id="producto_codigo" placeholder="Generando código..." readonly 
                        style="background-color: #f5f5f5; padding-right: 40px;">
                    <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #28a745;">
                        <i class="fas fa-bolt"></i> Auto
                    </span>
                </div>
                <small style="display:block; font-size:12px; color:#666; margin-top:5px;">
                    <i class="fas fa-info-circle"></i> Se genera automáticamente. No puede ser editado.
                </small>
            </div>
            <div class="form-group">
                <label>Nombre del Producto *</label>
                <select name="nombre" id="producto_nombre" class="form-select">
                    <option value="">Seleccionar producto...</option>
                    <option value="Cuenta de Ahorro Regular">Cuenta de Ahorro Regular</option>
                    <option value="Cuenta de Ahorro Juvenil">Cuenta de Ahorro Juvenil</option>
                    <option value="Cuenta de Ahorro Programado">Cuenta de Ahorro Programado</option>
                    <option value="Cuenta Corriente Personal">Cuenta Corriente Personal</option>
                    <option value="Cuenta Corriente Empresarial">Cuenta Corriente Empresarial</option>
                    <option value="Crédito Personal Express">Crédito Personal Express</option>
                    <option value="Crédito de Consumo">Crédito de Consumo</option>
                    <option value="Crédito Hipotecario">Crédito Hipotecario</option>
                    <option value="Crédito Automotriz">Crédito Automotriz</option>
                    <option value="Crédito Pyme">Crédito Pyme</option>
                    <option value="Tarjeta de Crédito Clásica">Tarjeta de Crédito Clásica</option>
                    <option value="Tarjeta de Crédito Gold">Tarjeta de Crédito Gold</option>
                    <option value="Tarjeta de Crédito Platinum">Tarjeta de Crédito Platinum</option>
                    <option value="Fondo de Inversión Moderado">Fondo de Inversión Moderado</option>
                    <option value="Fondo de Inversión Conservador">Fondo de Inversión Conservador</option>
                    <option value="Fondo de Inversión Agresivo">Fondo de Inversión Agresivo</option>
                    <option value="Depósito a Plazo Fijo 30 días">Depósito a Plazo Fijo 30 días</option>
                    <option value="Depósito a Plazo Fijo 90 días">Depósito a Plazo Fijo 90 días</option>
                    <option value="Depósito a Plazo Fijo 180 días">Depósito a Plazo Fijo 180 días</option>
                    <option value="Depósito a Plazo Fijo 360 días">Depósito a Plazo Fijo 360 días</option>
                    <option value="Seguro de Vida Individual">Seguro de Vida Individual</option>
                    <option value="Seguro de Vida Familiar">Seguro de Vida Familiar</option>
                    <option value="Seguro de Desgravamen">Seguro de Desgravamen</option>
                    <option value="Seguro de Bienes">Seguro de Bienes</option>
                    <option value="Seguro Vehicular">Seguro Vehicular</option>
                    <option value="Banca Electrónica Básica">Banca Electrónica Básica</option>
                    <option value="Banca Electrónica Premium">Banca Electrónica Premium</option>
                    <option value="Pago de Servicios">Pago de Servicios</option>
                    <option value="Transferencias Interbancarias">Transferencias Interbancarias</option>
                    <option value="Otro (Especificar en descripción)">Otro (Especificar en descripción)</option>
                </select>
                <small style="display:block; font-size:12px; color:#666; margin-top:5px;">
                    <i class="fas fa-info-circle"></i> Seleccione un producto de la lista
                </small>
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <select name="tipo" id="producto_tipo" class="form-select">
                    <option value="">Seleccionar...</option>
                    <option value="ahorro">Cuenta de Ahorro</option>
                    <option value="credito">Crédito</option>
                    <option value="inversion">Inversión</option>
                    <option value="seguros">Seguros</option>
                    <option value="tarjeta">Tarjeta de Crédito</option>
                    <option value="deposito">Depósito a Plazo</option>
                    <option value="servicio">Servicio Bancario</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Descripción *</label>
            <textarea name="descripcion" id="producto_descripcion" rows="3" placeholder="Describa el producto, sus características principales, público objetivo, etc."></textarea>
            <small class="form-text text-muted">Proporcione una descripción clara</small>
        </div>

        <div class="form-group">
            <label>Datos Personales Procesados *</label>
            <textarea name="datos_procesados" id="producto_datos" rows="4" placeholder="Ejemplo:
        - Nombre completo
        - Cédula de identidad
        - Fecha de nacimiento
        - Dirección
        - Teléfono
        - Correo electrónico

        Incluya todos los datos personales."></textarea>
            <small class="form-text text-muted">Liste los datos personales que se recopilan</small>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar Producto
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="resetFormProductos()" style="margin-left: 10px;">
            <i class="fas fa-redo"></i> Limpiar
        </button>
    </form>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Datos Procesados</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td><strong>{{ $producto->codigo }}</strong></td>
                    <td>{{ $producto->nombre }}</td>
                    <td>
                        @if($producto->tipo === 'ahorro')
                            <span class="badge badge-info">Ahorro</span>
                        @elseif($producto->tipo === 'credito')
                            <span class="badge badge-success">Crédito</span>
                        @elseif($producto->tipo === 'inversion')
                            <span class="badge badge-warning">Inversión</span>
                        @elseif($producto->tipo === 'seguros')
                            <span class="badge badge-primary">Seguros</span>
                        @elseif($producto->tipo === 'tarjeta')
                            <span class="badge badge-danger">Tarjeta</span>
                        @elseif($producto->tipo === 'deposito')
                            <span class="badge badge-secondary">Depósito</span>
                        @elseif($producto->tipo === 'servicio')
                            <span class="badge badge-dark">Servicio</span>
                        @endif
                    </td>
                    <td>{{ $producto->descripcion ? Str::limit($producto->descripcion, 50) : 'N/A' }}</td>
                    <td>
                        @if($producto->datos_procesados)
                            <button type="button" class="btn btn-sm btn-info" onclick="Swal.fire({
                                title: 'Datos Procesados: {{ $producto->nombre }}',
                                html: `<pre style='text-align: left; white-space: pre-wrap;'>{{ $producto->datos_procesados }}</pre>`,
                                confirmButtonText: 'Cerrar'
                            })">
                                Ver Datos
                            </button>
                        @else
                            <span class="badge badge-danger">No definidos</span>
                        @endif
                    </td>
                    <td>
                        @if($producto->estado === 'activo')
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-secondary" style="padding: 8px 15px;"
                            onclick="editarProducto(
                                {{ $producto->id }},
                                '{{ $producto->codigo }}',
                                '{{ $producto->nombre }}',
                                '{{ $producto->tipo }}',
                                `{{ str_replace('"', '&quot;', $producto->descripcion ?? '') }}`,
                                `{{ str_replace('"', '&quot;', $producto->datos_procesados ?? '') }}`
                            )">
                            <i class="fas fa-edit"></i> Editar
                        </button>

                        <form action="{{ route('productos.estado', $producto->id) }}"
                            method="POST"
                            style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-exchange-alt"></i> Estado
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <i class="fas fa-box-open" style="font-size: 24px; margin-bottom: 10px; display: block; color: #999;"></i>
                        No hay productos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// PRIMERO: Remover TODOS los atributos de validación al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Iniciando limpieza de validación');
    
    // Remover atributos de validación del select
    const selectNombre = document.getElementById('producto_nombre');
    if (selectNombre) {
        console.log('Limpiando select producto_nombre');
        // Remover TODOS los atributos que puedan causar validación
        selectNombre.removeAttribute('required');
        selectNombre.removeAttribute('minlength');
        selectNombre.removeAttribute('maxlength');
        selectNombre.removeAttribute('pattern');
        selectNombre.removeAttribute('data-val');
        selectNombre.removeAttribute('data-val-required');
        selectNombre.removeAttribute('data-val-length');
        selectNombre.removeAttribute('data-val-minlength');
        selectNombre.removeAttribute('data-val-maxlength');
        
        // Verificar que no queden atributos
        console.log('Atributos actuales:', selectNombre.outerHTML);
    }
    
    // También limpiar los textareas
    ['producto_descripcion', 'producto_datos'].forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.removeAttribute('required');
            field.removeAttribute('minlength');
            field.removeAttribute('maxlength');
        }
    });
    
    // Remover validación HTML5 de TODO el formulario
    const form = document.getElementById('formProductos');
    if (form) {
        form.setAttribute('novalidate', 'novalidate');
        form.noValidate = true;
        
        // Eliminar todos los event listeners de submit previos
        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);
        
        console.log('Formulario clonado y reemplazado para eliminar event listeners');
    }
});

// SEGUNDO: Agregar validación manual COMPLETA
window.addEventListener('load', function() {
    console.log('Página completamente cargada - Configurando validación personalizada');
    
    const formProductos = document.getElementById('formProductos');
    if (!formProductos) {
        console.error('Formulario no encontrado');
        return;
    }
    
    // PREVENIR CUALQUIER validación HTML5
    formProductos.addEventListener('invalid', function(e) {
        e.preventDefault();
        e.stopPropagation();
    }, true);
    
    // Sobreescribir el evento submit
    formProductos.addEventListener('submit', function(e) {
        console.log('Submit detectado - Validando manualmente');
        e.preventDefault();
        e.stopPropagation();
        
        // Obtener valores
        const productoNombre = document.getElementById('producto_nombre');
        const productoTipo = document.getElementById('producto_tipo');
        const productoDescripcion = document.getElementById('producto_descripcion');
        const productoDatos = document.getElementById('producto_datos');
        
        // Limpiar errores previos
        [productoNombre, productoTipo, productoDescripcion, productoDatos].forEach(field => {
            field.classList.remove('is-invalid');
            field.style.borderColor = '';
        });
        
        // Validar manualmente
        let errores = [];
        
        if (!productoNombre.value) {
            errores.push('Debe seleccionar un nombre de producto');
            productoNombre.classList.add('is-invalid');
            productoNombre.style.borderColor = '#dc3545';
        }
        
        if (!productoTipo.value) {
            errores.push('Debe seleccionar un tipo de producto');
            productoTipo.classList.add('is-invalid');
            productoTipo.style.borderColor = '#dc3545';
        }
        
        if (!productoDescripcion.value || productoDescripcion.value.trim().length < 10) {
            errores.push('La descripción debe tener al menos 10 caracteres');
            productoDescripcion.classList.add('is-invalid');
            productoDescripcion.style.borderColor = '#dc3545';
        }
        
        if (!productoDatos.value || productoDatos.value.trim().length < 2) {
            errores.push('Los datos procesados deben tener al menos 2 caracteres');
            productoDatos.classList.add('is-invalid');
            productoDatos.style.borderColor = '#dc3545';
        }
        
        // Si hay errores, mostrar
        if (errores.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: '<div style="text-align: left; margin: 15px;">' + 
                      errores.map(error => `<div style="margin-bottom: 5px;">• ${error}</div>`).join('') + 
                      '</div>',
                confirmButtonText: 'Entendido',
                width: 600
            });
            
            // Enfocar el primer campo con error
            if (!productoNombre.value) productoNombre.focus();
            else if (!productoTipo.value) productoTipo.focus();
            else if (!productoDescripcion.value || productoDescripcion.value.trim().length < 10) productoDescripcion.focus();
            else productoDatos.focus();
            
            return false;
        }
        
        // Si pasa validación, enviar
        console.log('Validación pasada - Enviando formulario');
        
        // Mostrar loader
        Swal.fire({
            title: 'Procesando...',
            text: 'Guardando producto',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Enviar formulario de forma asíncrona
        const formData = new FormData(formProductos);
        const action = formProductos.getAttribute('action');
        const method = document.getElementById('form_producto_method')?.value || 'POST';
        
        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.text())
        .then(data => {
            Swal.close();
            // Recargar la página para ver los cambios
            window.location.reload();
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar el producto: ' + error.message
            });
        });
        
        return false;
    });
    
    // Inicializar generador de códigos
    window.generadorCodigos = new GeneradorCodigos();
    
    // Configurar auto-sugerencia de tipo
    const productoNombreSelect = document.getElementById('producto_nombre');
    const productoTipoSelect = document.getElementById('producto_tipo');
    
    if (productoNombreSelect && productoTipoSelect) {
        productoNombreSelect.addEventListener('change', function() {
            const valor = this.value;
            
            if (valor.includes('Ahorro') || valor.includes('Corriente')) {
                productoTipoSelect.value = 'ahorro';
            } else if (valor.includes('Crédito')) {
                productoTipoSelect.value = 'credito';
            } else if (valor.includes('Tarjeta')) {
                productoTipoSelect.value = 'tarjeta';
            } else if (valor.includes('Inversión') || valor.includes('Fondo')) {
                productoTipoSelect.value = 'inversion';
            } else if (valor.includes('Seguro')) {
                productoTipoSelect.value = 'seguros';
            } else if (valor.includes('Depósito')) {
                productoTipoSelect.value = 'deposito';
            } else if (valor.includes('Banca') || valor.includes('Pago') || valor.includes('Transferencia')) {
                productoTipoSelect.value = 'servicio';
            }
            
            // Limpiar error si existía
            this.classList.remove('is-invalid');
            this.style.borderColor = '';
        });
    }
});

// TERCERO: Mantener las otras funciones pero asegurarnos que no interfieran
class GeneradorCodigos {
    constructor() {
        this.prefijo = 'B';
        this.digitos = 3;
        this.init();
    }
    
    init() {
        this.cargarCodigosExistentes();
        this.configurarEventos();
        this.generarSiNecesario();
    }
    
    cargarCodigosExistentes() {
        this.codigos = [];
        document.querySelectorAll('#productos table tbody tr td:first-child').forEach(td => {
            const codigo = td.textContent.trim();
            if (codigo) this.codigos.push(codigo);
        });
    }
    
    getSiguienteCodigo() {
        let siguienteNumero = 1;
        
        this.codigos.forEach(codigo => {
            const match = codigo.match(new RegExp(`${this.prefijo}(\\d+)`, 'i'));
            if (match) {
                const num = parseInt(match[1]);
                if (num >= siguienteNumero) siguienteNumero = num + 1;
            }
        });
        
        let codigoPropuesto;
        let intentos = 0;
        
        do {
            codigoPropuesto = this.prefijo + siguienteNumero.toString().padStart(this.digitos, '0');
            if (!this.codigos.includes(codigoPropuesto)) break;
            siguienteNumero++;
            intentos++;
        } while (intentos < 100);
        
        return codigoPropuesto;
    }
    
    generarSiNecesario() {
        const input = document.getElementById('producto_codigo');
        const enEdicion = document.getElementById('producto_id').value;
        
        if (!enEdicion) {
            this.cargarCodigosExistentes();
            const nuevoCodigo = this.getSiguienteCodigo();
            input.value = nuevoCodigo;
            input.setAttribute('readonly', true);
            input.style.backgroundColor = '#f5f5f5';
        } else {
            input.setAttribute('readonly', true);
            input.style.backgroundColor = '#f5f5f5';
        }
    }
    
    configurarEventos() {
        const observer = new MutationObserver(() => {
            if (document.getElementById('productos').classList.contains('active')) {
                setTimeout(() => this.generarSiNecesario(), 100);
            }
        });
        
        observer.observe(document.getElementById('productos'), {
            attributes: true,
            attributeFilter: ['class']
        });
    }
}

// Cuarta: Función para editar producto (modificada)
function editarProducto(id, codigo, nombre, tipo, descripcion, datos) {
    document.getElementById('producto_id').value = id;
    document.getElementById('producto_codigo').value = codigo;
    document.getElementById('producto_nombre').value = nombre;
    document.getElementById('producto_tipo').value = tipo;
    document.getElementById('producto_descripcion').value = descripcion;
    document.getElementById('producto_datos').value = datos;
    
    document.getElementById('producto_codigo').setAttribute('readonly', true);
    document.getElementById('producto_codigo').style.backgroundColor = '#f5f5f5';
    
    document.getElementById('form_producto_method').value = 'PUT';
    document.getElementById('formProductos').action = '/productos/' + id;
    
    const btnSubmit = document.querySelector('#formProductos button[type="submit"]');
    btnSubmit.innerHTML = '<i class="fas fa-sync-alt"></i> Actualizar Producto';
    btnSubmit.style.backgroundColor = '#28a745';
    
    Swal.fire({
        icon: 'info',
        title: 'Modo edición',
        text: 'Editando producto: ' + codigo,
        timer: 2000,
        showConfirmButton: false
    });
}

// Quinta: Función para resetear
function resetFormProductos() {
    if (confirm('¿Limpiar formulario? Se generará un nuevo código automático.')) {
        document.getElementById('producto_id').value = '';
        document.getElementById('form_producto_method').value = 'POST';
        document.getElementById('formProductos').action = "{{ route('productos.store') }}";
        document.getElementById('producto_nombre').value = '';
        document.getElementById('producto_tipo').value = '';
        document.getElementById('producto_descripcion').value = '';
        document.getElementById('producto_datos').value = '';
        
        const btnSubmit = document.querySelector('#formProductos button[type="submit"]');
        btnSubmit.innerHTML = '<i class="fas fa-save"></i> Guardar Producto';
        btnSubmit.style.backgroundColor = '';
        
        if (window.generadorCodigos) {
            window.generadorCodigos.generarSiNecesario();
        }
        
        // Limpiar errores visuales
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
            el.style.borderColor = '';
        });
        
        Swal.fire({
            icon: 'success',
            title: 'Formulario limpio',
            text: 'Se ha generado un nuevo código automático',
            timer: 1500,
            showConfirmButton: false
        });
    }
}

// SEXTA: Estilos CSS que PREVIENEN la validación nativa
const estilo = document.createElement('style');
estilo.textContent = `
    /* Deshabilitar COMPLETAMENTE la validación nativa */
    input:invalid, select:invalid, textarea:invalid {
        box-shadow: none !important;
        outline: none !important;
    }
    
    /* Ocultar mensajes de validación nativos */
    input::-webkit-validation-bubble-message,
    select::-webkit-validation-bubble-message,
    textarea::-webkit-validation-bubble-message {
        display: none !important;
    }
    
    /* Estilos personalizados */
    .is-invalid {
        border: 2px solid #dc3545 !important;
        background-color: #fff5f5 !important;
    }
    
    .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
        background-color: white;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(estilo);
</script>
        
        <!-- CONSENTIMIENTOS ------------------------------------------------------------------------------------>
        <div id="consentimientos" class="content-section">
            <h2 class="section-title">Gestión de Consentimientos</h2>
            
            <form id="formConsentimientos" method="POST" action="{{ route('consentimientos.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form_consentimiento_method" value="POST">
                <input type="hidden" name="id" id="consentimiento_id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Sujeto de Datos (ID) *</label>
                        <select name="sujeto_id" id="consentimiento_sujeto_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach($sujetos as $sujeto)
                                <option value="{{ $sujeto->id }}">{{ $sujeto->cedula }} - {{ $sujeto->nombre }}</option>
                            @endforeach
                        </select>
                        <span class="text-error" id="error-sujeto_id"></span>
                    </div>
                    <div class="form-group">
                        <label>Propósito del Tratamiento *</label>
                        <select name="proposito" id="consentimiento_proposito" required>
                            <option value="">Seleccionar...</option>
                            <option value="productos">Oferta de Productos</option>
                            <option value="marketing">Marketing</option>
                            <option value="analisis">Análisis Crediticio</option>
                            <option value="cumplimiento">Cumplimiento Legal</option>
                        </select>
                        <span class="text-error" id="error-proposito"></span>
                    </div>
                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" id="consentimiento_estado" required>
                            <option value="">Seleccionar...</option>
                            <option value="otorgado">Otorgado</option>
                            <option value="revocado">Revocado</option>
                            <option value="pendiente">Pendiente</option>
                        </select>
                        <span class="text-error" id="error-estado"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha de Otorgamiento (Hoy) *</label>
                        <input type="date" name="fecha_otorgamiento" id="consentimiento_fecha_otorgamiento" value="{{ date('Y-m-d') }}" readonly style="background-color: #f0f0f0; cursor: not-allowed;">
                        <small style="display: block; margin-top: 5px; color: #666;">Esta fecha se establece automáticamente con la fecha actual</small>
                        <span class="text-error" id="error-fecha_otorgamiento"></span>
                    </div>
                    <div class="form-group">
                        <label>Método de Obtención *</label>
                        <select name="metodo" id="consentimiento_metodo" required>
                            <option value="">Seleccionar...</option>
                            <option value="presencial">Presencial</option>
                            <option value="digital">Digital</option>
                            <option value="telefono">Telefónico</option>
                        </select>
                        <span class="text-error" id="error-metodo"></span>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Expiración *</label>
                        <input type="date" name="fecha_expiracion" id="consentimiento_fecha_expiracion" value="{{ date('Y-m-d', strtotime('+1 year')) }}" readonly style="background-color: #f0f0f0; cursor: not-allowed;" required>
                        <small style="display: block; margin-top: 5px; color: #666;">Se establece automáticamente un año desde la fecha de otorgamiento</small>
                        <span class="text-error" id="error-fecha_expiracion"></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Consentimiento</button>
            </form>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sujeto</th>
                            <th>Propósito</th>
                            <th>Fecha Otorgamiento</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consentimientos as $consentimiento)
                        <tr>
                            <td>{{ $consentimiento->id }}</td>
                            <td>{{ $consentimiento->sujeto->cedula }} - {{ $consentimiento->sujeto->nombre }}</td>
                            <td>
                                @if($consentimiento->proposito === 'productos')
                                    <span class="badge badge-info">Oferta de Productos</span>
                                @elseif($consentimiento->proposito === 'marketing')
                                    <span class="badge badge-success">Marketing</span>
                                @elseif($consentimiento->proposito === 'analisis')
                                    <span class="badge badge-warning">Análisis Crediticio</span>
                                @elseif($consentimiento->proposito === 'cumplimiento')
                                    <span class="badge badge-primary">Cumplimiento Legal</span>
                                @endif
                            </td>
                            <td>{{ $consentimiento->fecha_otorgamiento ? \Carbon\Carbon::parse($consentimiento->fecha_otorgamiento)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                @if($consentimiento->metodo === 'presencial')
                                    <span class="badge badge-success">Presencial</span>
                                @elseif($consentimiento->metodo === 'digital')
                                    <span class="badge badge-info">Digital</span>
                                @elseif($consentimiento->metodo === 'telefono')
                                    <span class="badge badge-warning">Telefónico</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($consentimiento->estado === 'otorgado')
                                    <span class="badge badge-success">Otorgado</span>
                                @elseif($consentimiento->estado === 'revocado')
                                    <span class="badge badge-danger">Revocado</span>
                                @elseif($consentimiento->estado === 'pendiente')
                                    <span class="badge badge-warning">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-secondary" style="padding: 8px 15px;"
                                    onclick="editarConsentimiento(
                                        {{ $consentimiento->id }},
                                        {{ $consentimiento->sujeto_id }},
                                        '{{ $consentimiento->proposito }}',
                                        '{{ $consentimiento->estado }}',
                                        '{{ $consentimiento->fecha_otorgamiento }}',
                                        '{{ $consentimiento->metodo }}',
                                        '{{ $consentimiento->fecha_expiracion }}'
                                    )">
                                    Editar
                                </button>

                                <form action="{{ route('consentimientos.toggleActivo', $consentimiento->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $consentimiento->activo ? 'btn-success' : 'btn-warning' }}"
                                        style="padding: 8px 15px;">
                                        {{ $consentimiento->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay consentimientos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        

<!-- SOLICITUDES DSAR ---------------------------------------------------------------------------->
@php
    use App\Models\SolicitudDsar;

    // Próximo número tipo S001
    $ultimo = SolicitudDsar::orderBy('id', 'desc')->first();

    if ($ultimo && preg_match('/S(\d+)/', $ultimo->numero_solicitud, $matches)) {
        $numero = intval($matches[1]) + 1;
    } else {
        $numero = 1;
    }

    $siguienteNumero = 'S' . str_pad($numero, 3, '0', STR_PAD_LEFT);

    $hoy = now()->toDateString();
    $minPlazo = now()->addDays(2)->toDateString();
@endphp

<div id="dsar" class="content-section">
    <h2 class="section-title">Solicitudes de Derechos (DSAR)</h2>
    <p style="margin-bottom: 20px; color: #666;">
        Gestión de solicitudes de Acceso, Rectificación, Cancelación y Oposición
    </p>

    {{-- FORMULARIO --}}
    <form id="formDSAR" method="POST" action="{{ route('dsar.store') }}">
        @csrf
        <input type="hidden" name="_method" id="form_dsar_method" value="POST">

        <div class="form-row">
            <div class="form-group">
                <label>Número de Solicitud *</label>
                <input
                    type="text"
                    name="numero_solicitud"
                    id="dsar_numero"
                    value="{{ $siguienteNumero }}"
                    readonly
                    style="background:#f5f5f5;cursor:not-allowed;"
                >
                <small style="color:#666;">⚡ Auto</small>
            </div>

            <div class="form-group">
                <label for="dsar_cedula">Sujeto de Datos *</label>
                <select name="cedula" id="dsar_cedula" required>
                    <option value="">Seleccione un Sujeto de Datos</option>
                    @foreach ($sujetos as $s)
                        <option value="{{ $s->cedula }}">
                            {{ $s->nombre }} {{ $s->apellido }} — {{ $s->cedula }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tipo de Solicitud *</label>
                <select name="tipo" id="dsar_tipo" required>
                    <option value="">Seleccionar...</option>
                    <option value="acceso">Acceso</option>
                    <option value="rectificacion">Rectificación</option>
                    <option value="cancelacion">Cancelación</option>
                    <option value="oposicion">Oposición</option>
                    <option value="portabilidad">Portabilidad</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Descripción *</label>
            <textarea name="descripcion" id="dsar_descripcion" rows="4" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Solicitud *</label>
                <input
                    type="date"
                    name="fecha_solicitud"
                    id="dsar_fecha_solicitud"
                    value="{{ $hoy }}"
                    min="{{ $hoy }}"
                    max="{{ $hoy }}"
                    readonly
                    style="background:#f5f5f5;cursor:not-allowed;"
                >
            </div>

            <div class="form-group">
                <label>Plazo de Respuesta</label>
                <input
                    type="date"
                    name="fecha_limite"
                    id="dsar_fecha_limite"
                    min="{{ $minPlazo }}"
                >
                <small style="color:#666;"></small>
            </div>

            <div class="form-group">
                <label>Estado *</label>
                <select name="estado" id="dsar_estado" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="proceso">En Proceso</option>
                    <option value="completada">Completada</option>
                    <option value="rechazada">Rechazada</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="btnDsarGuardar">
            Registrar Solicitud
        </button>

        <button type="button" class="btn btn-secondary" onclick="resetFormularioDSAR()" style="margin-left:10px;">
            Cancelar Edición
        </button>
    </form>

    {{-- TABLA --}}
    <div class="table-container" style="margin-top:25px;">
        <table>
            <thead>
                <tr>
                    <th>N° Solicitud</th>
                    <th>Solicitante</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Plazo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @forelse($dsars as $d)
                <tr>
                    <td>{{ $d->numero_solicitud }}</td>
                    <td>
                        {{ $d->sujeto?->nombre }} {{ $d->sujeto?->apellido }} — {{ $d->sujeto?->cedula }}
                    </td>
                    <td>{{ ucfirst($d->tipo) }}</td>
                    <td>{{ $d->fecha_solicitud }}</td>
                    <td>{{ $d->fecha_limite ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-warning">
                            {{ ucfirst($d->estado) }}
                        </span>
                    </td>

                    <td style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        {{-- EDITAR --}}
                        <button type="button"
                            class="btn btn-secondary btn-editar-dsar"
                            data-id="{{ $d->id }}"
                            data-numero="{{ $d->numero_solicitud }}"
                            data-cedula="{{ $d->sujeto?->cedula }}"
                            data-tipo="{{ $d->tipo }}"
                            data-descripcion="{{ $d->descripcion }}"
                            data-fecha="{{ $d->fecha_solicitud }}"
                            data-limite="{{ $d->fecha_limite }}"
                            data-estado="{{ $d->estado }}">
                            Editar
                        </button>

                        {{-- CAMBIAR ESTADO --}}
                        <form method="POST" action="{{ route('dsar.update', $d->id) }}" style="display:flex; gap:8px;">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="numero_solicitud" value="{{ $d->numero_solicitud }}">
                            <input type="hidden" name="cedula" value="{{ $d->sujeto?->cedula }}">
                            <input type="hidden" name="tipo" value="{{ $d->tipo }}">
                            <input type="hidden" name="descripcion" value="{{ $d->descripcion }}">
                            <input type="hidden" name="fecha_solicitud" value="{{ $d->fecha_solicitud }}">
                            <input type="hidden" name="fecha_limite" value="{{ $d->fecha_limite }}">

                            <select name="estado">
                                <option value="pendiente" {{ $d->estado=='pendiente'?'selected':'' }}>Pendiente</option>
                                <option value="proceso" {{ $d->estado=='proceso'?'selected':'' }}>En Proceso</option>
                                <option value="completada" {{ $d->estado=='completada'?'selected':'' }}>Completada</option>
                                <option value="rechazada" {{ $d->estado=='rechazada'?'selected':'' }}>Rechazada</option>
                            </select>

                            <button type="submit" class="btn btn-warning">Cambiar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">
                        No hay solicitudes DSAR registradas
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- JS EDITAR DSAR --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formDSAR');
    if (!form) return;

    const methodInput = document.getElementById('form_dsar_method');

    const inputNumero = document.getElementById('dsar_numero');
    const selectCedula = document.getElementById('dsar_cedula');
    const selectTipo = document.getElementById('dsar_tipo');
    const textareaDesc = document.getElementById('dsar_descripcion');
    const inputFecha = document.getElementById('dsar_fecha_solicitud');
    const inputLimite = document.getElementById('dsar_fecha_limite');
    const selectEstado = document.getElementById('dsar_estado');

    const storeAction = form.getAttribute('action');

    document.querySelectorAll('.btn-editar-dsar').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;

            form.setAttribute('action', `/dsar/${id}`);
            methodInput.value = 'PUT';

            inputNumero.value = btn.dataset.numero || '';
            selectCedula.value = btn.dataset.cedula || '';
            selectTipo.value = btn.dataset.tipo || '';
            textareaDesc.value = btn.dataset.descripcion || '';
            inputFecha.value = btn.dataset.fecha || '';
            inputLimite.value = btn.dataset.limite || '';
            selectEstado.value = btn.dataset.estado || 'pendiente';

            const btnGuardar = document.getElementById('btnDsarGuardar');
            if (btnGuardar) btnGuardar.textContent = 'Actualizar Solicitud';

            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    window.resetFormularioDSAR = function () {
        form.setAttribute('action', storeAction);
        methodInput.value = 'POST';

        selectCedula.value = '';
        selectTipo.value = '';
        textareaDesc.value = '';
        inputLimite.value = '';
        selectEstado.value = 'pendiente';

        const btnGuardar = document.getElementById('btnDsarGuardar');
        if (btnGuardar) btnGuardar.textContent = 'Registrar Solicitud';
    }
});
</script>



<!-- INCIDENTES ------------------------------------------------------------------------------------->
<div id="incidentes" class="content-section">
    <h2 class="section-title">Registro de Incidentes de Seguridad</h2>

    <div class="alert alert-danger">
        <strong>⚠️ Atención:</strong> Registre todos los incidentes de seguridad que involucren datos personales
    </div>

    {{-- FORMULARIO --}}
    @php
        $tipoLabels = [
            'destruccion' => 'destrucción de datos personales',
            'perdida' => 'pérdida de datos personales',
            'alteracion' => 'alteración de datos personales',
            'divulgacion' => 'divulgación no autorizada de datos personales',
            'acceso_no_autorizado' => 'acceso no autorizado a datos personales',
        ];
        $estadoLabels = [
            'abierto' => 'detección y registro del incidente',
            'investigacion' => 'evaluación del alcance y del riesgo',
            'controlado' => 'aplicación de medidas técnicas y organizativas',
            'resuelto' => 'cierre documentado del incidente',
        ];
    @endphp
    <form id="formIncidentes" method="POST" action="{{ route('incidentes.store') }}">
        @csrf
        <input type="hidden" name="_method" id="form_incidente_method" value="POST">
        <input type="hidden" id="incidente_id">

        <div class="form-row">
            <div class="form-group">
                <label>Código de Incidente *</label>
                <input type="text"
                    id="codigo"
                    name="codigo"
                    value="{{ old('codigo', $siguienteCodigo ?? ($incidenteEditar->codigo ?? '')) }}"
                    readonly
                    style="background:#f3f3f3; cursor:not-allowed;">
                @error('codigo')
                    <small class="text-error">El código es obligatorio</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Fecha del Incidente *</label>
                <input type="datetime-local"
                    name="fecha"
                    id="fecha"
                    value="{{ old('fecha') }}"
                    required
                    min="{{ now()->subDay()->format('Y-m-d\T00:00') }}"
                    max="{{ now()->format('Y-m-d\T23:59') }}"
                    class="{{ $errors->has('fecha') ? 'input-error' : '' }}">

                @error('fecha')
                    <small class="text-error">La fecha es obligatoria</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Severidad *</label>
                <select name="severidad"
                        id="severidad"
                        class="{{ $errors->has('severidad') ? 'input-error' : '' }}">
                    <option value="">Seleccionar...</option>
                    <option value="baja" {{ old('severidad')=='baja'?'selected':'' }}>Baja</option>
                    <option value="media" {{ old('severidad')=='media'?'selected':'' }}>Media</option>
                    <option value="alta" {{ old('severidad')=='alta'?'selected':'' }}>Alta</option>
                    <option value="critica" {{ old('severidad')=='critica'?'selected':'' }}>Crítica</option>
                </select>
                @error('severidad')
                    <small class="text-error">Seleccione una severidad</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Descripción del Incidente *</label>
            <textarea name="descripcion"
                      id="descripcion"
                      rows="4"
                      class="{{ $errors->has('descripcion') ? 'input-error' : '' }}">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <small class="text-error">La descripción es obligatoria</small>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tipo de Incidente *</label>
                <select name="tipo"
                        id="tipo"
                        class="{{ $errors->has('tipo') ? 'input-error' : '' }}">
                    <option value="">Seleccionar...</option>
                    <option value="destruccion" {{ old('tipo')=='destruccion'?'selected':'' }}>destrucción de datos personales</option>
                    <option value="perdida" {{ old('tipo')=='perdida'?'selected':'' }}>pérdida de datos personales</option>
                    <option value="alteracion" {{ old('tipo')=='alteracion'?'selected':'' }}>alteración de datos personales</option>
                    <option value="divulgacion" {{ old('tipo')=='divulgacion'?'selected':'' }}>divulgación no autorizada de datos personales</option>
                    <option value="acceso_no_autorizado" {{ old('tipo')=='acceso_no_autorizado'?'selected':'' }}>acceso no autorizado a datos personales</option>
                </select>
                @error('tipo')
                    <small class="text-error">Seleccione el tipo de incidente</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Sujetos Afectados *</label>
                <input type="number"
                       name="sujetos_afectados"
                       id="sujetos_afectados"
                       min="1"
                       required
                       value="{{ old('sujetos_afectados') }}">
                @error('sujetos_afectados')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Estado *</label>
                <select name="estado"
                        id="estado"
                        class="{{ $errors->has('estado') ? 'input-error' : '' }}">
                    <option value="abierto" {{ old('estado')=='abierto'?'selected':'' }}>detección y registro del incidente</option>
                    <option value="investigacion" {{ old('estado')=='investigacion'?'selected':'' }}>evaluación del alcance y del riesgo</option>
                    <option value="controlado" {{ old('estado')=='controlado'?'selected':'' }}>aplicación de medidas técnicas y organizativas</option>
                    <option value="resuelto" {{ old('estado')=='resuelto'?'selected':'' }}>cierre documentado del incidente</option>
                </select>
                @error('estado')
                    <small class="text-error">Seleccione un estado</small>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Registrar Incidente
        </button>
    </form>

    <!-- TABLA DE INCIDENTES (AHORA SÍ DENTRO DE #incidentes) -->
    <div class="table-container" style="margin-top:25px;">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Severidad</th>
                    <th>Afectados</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($incidentes as $incidente)
                <tr>
                    <td>{{ $incidente->codigo }}</td>
                    <td>{{ \Carbon\Carbon::parse($incidente->fecha)->format('d/m/Y H:i') }}</td>
                    <td>{{ $tipoLabels[$incidente->tipo] ?? ucfirst($incidente->tipo) }}</td>
                    <td>
                        <span class="badge 
                            @if($incidente->severidad=='baja') badge-success
                            @elseif($incidente->severidad=='media') badge-warning
                            @elseif($incidente->severidad=='alta') badge-danger
                            @else badge-dark @endif">
                            {{ ucfirst($incidente->severidad) }}
                        </span>
                    </td>
                    <td>{{ $incidente->sujetos_afectados ?? 0 }}</td>
                    <td>
                        <span class="badge 
                            @if($incidente->estado=='abierto') badge-info
                            @elseif($incidente->estado=='investigacion') badge-warning
                            @elseif($incidente->estado=='controlado') badge-secondary
                            @else badge-success @endif">
                            {{ $estadoLabels[$incidente->estado] ?? ucfirst($incidente->estado) }}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary"
                            onclick="editarIncidente(
                                '{{ $incidente->id }}',
                                '{{ $incidente->codigo }}',
                                '{{ $incidente->fecha }}',
                                '{{ $incidente->severidad }}',
                                `{{ $incidente->descripcion }}`,
                                '{{ $incidente->tipo }}',
                                '{{ $incidente->sujetos_afectados }}',
                                '{{ $incidente->estado }}'
                            )">
                            Editar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No hay incidentes registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function editarIncidente(id, codigo, fecha, severidad, descripcion, tipo, afectados, estado){
    Swal.fire({
                icon: 'info',
                title: 'Editar Incidente',
                text: 'El formulario ha entrado en modo edición'
            });
    document.getElementById('incidente_id').value = id;
    document.getElementById('codigo').value = codigo;
    document.getElementById('fecha').value = fecha.replace(' ', 'T'); // Para datetime-local
    document.getElementById('severidad').value = severidad;
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('tipo').value = tipo;
    document.getElementById('sujetos_afectados').value = afectados;
    document.getElementById('estado').value = estado;

    document.getElementById('form_incidente_method').value = 'PUT';
    document.getElementById('formIncidentes').action = '/incidentes/' + id;
}

// Validación cliente: fecha dentro del rango y hora entre 08:00 y 21:00
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('formIncidentes');
    const fechaInput = document.getElementById('fecha');

    if (!form || !fechaInput) return;

    function parseDateTimeLocal(value){
        // value expected 'YYYY-MM-DDTHH:MM' or 'YYYY-MM-DDTHH:MM:SS'
        const parts = value.split('T');
        if (parts.length !== 2) return null;
        const d = parts[0].split('-');
        const t = parts[1].split(':');
        if (d.length < 3 || t.length < 2) return null;
        return new Date(parseInt(d[0],10), parseInt(d[1],10)-1, parseInt(d[2],10), parseInt(t[0],10), parseInt(t[1],10));
    }

    form.addEventListener('submit', function(e){
        const val = fechaInput.value;
        if (!val) return; // required handled by browser

        const selected = parseDateTimeLocal(val);
        if (!selected) return; // let server handle

        // range from input.min to input.max (both provided by server)
        const minStr = fechaInput.getAttribute('min');
        const maxStr = fechaInput.getAttribute('max');
        const minDate = parseDateTimeLocal(minStr) || null;
        const maxDate = parseDateTimeLocal(maxStr) || null;

        if (minDate && selected < minDate) {
            e.preventDefault();
            Swal.fire({icon:'error', title:'Fecha inválida', text:`La fecha mínima permitida es ${minDate.toLocaleString()}`});
            fechaInput.classList.add('input-error');
            return;
        }

        if (maxDate && selected > maxDate) {
            e.preventDefault();
            Swal.fire({icon:'error', title:'Fecha inválida', text:`La fecha máxima permitida es ${maxDate.toLocaleString()}`});
            fechaInput.classList.add('input-error');
            return;
        }

        // validar hora 08:00 - 21:00 (permitir 21:00 exacto)
        const hour = selected.getHours();
        const minute = selected.getMinutes();

        if (hour < 9) {
            e.preventDefault();
            Swal.fire({icon:'error', title:'Hora inválida', text:'La hora debe ser a partir de las 09:00'});
            fechaInput.classList.add('input-error');
            return;
        }

        if (hour > 21 || (hour === 21 && minute > 0)) {
            e.preventDefault();
            Swal.fire({icon:'error', title:'Hora inválida', text:'La hora no puede ser posterior a las 21:00'});
            fechaInput.classList.add('input-error');
            return;
        }

        fechaInput.classList.remove('input-error');
    });

    // Corregir/limitar automáticamente la hora cuando el usuario cambia el campo
    fechaInput.addEventListener('change', function(){
        const val = this.value;
        if (!val) return;
        const dt = parseDateTimeLocal(val);
        if (!dt) return;

        const h = dt.getHours();
        const m = dt.getMinutes();

        // Si antes de 09:00, ajustar a 09:00
        if (h < 9) {
            dt.setHours(9, 0, 0, 0);
            this.value = dt.toISOString().slice(0,16);
            Swal.fire({icon:'warning', title:'Hora ajustada', text:'La hora mínima permitida es 09:00. Se ajustó automáticamente.'});
            return;
        }

        // Si después de 21:00, ajustar a 21:00 exacto
        if (h > 21 || (h === 21 && m > 0)) {
            dt.setHours(21, 0, 0, 0);
            this.value = dt.toISOString().slice(0,16);
            Swal.fire({icon:'warning', title:'Hora ajustada', text:'La hora máxima permitida es 21:00. Se ajustó automáticamente.'});
            return;
        }
    });
});

// Genera y muestra el siguiente código de incidente si el formulario está en modo creación
function generarSiguienteCodigoIncidente() {
    const input = document.getElementById('codigo');
    const enEdicion = document.getElementById('incidente_id').value;
    if (enEdicion) return; // no sobrescribir en edición
    if (input.value && input.value.trim()) return; // ya tiene valor (viene del servidor)

    // Obtener códigos desde la tabla
    const codigos = [];
    document.querySelectorAll('#incidentes table tbody tr td:first-child').forEach(td => {
        const t = td.textContent.trim();
        if (t) codigos.push(t);
    });

    if (codigos.length === 0) {
        input.value = 'INC-001';
        return;
    }

    // Priorizar códigos con prefijo INC- si existen
    const incCodes = codigos.filter(c => /^inc[-_]/i.test(c) || /^inc/i.test(c));
    const candidatos = incCodes.length ? incCodes : codigos;

    let maxNum = 0;
    let prefijo = 'INC-';
    candidatos.forEach(c => {
        const m = c.match(/^([A-Za-z\-]+)(\d+)$/);
        if (m) {
            const p = m[1].toUpperCase();
            const n = parseInt(m[2], 10);
            // si es el primer match, usar su prefijo para formar el siguiente
            if (n > maxNum) {
                maxNum = n;
                prefijo = p;
            }
        }
    });

    const next = (maxNum + 1).toString().padStart(3, '0'); // padding a 3 dígitos
    input.value = `${prefijo}${next}`;
}

// Observador para asignar código cuando se muestre la sección incidentes
const observerIncidentes = new MutationObserver(() => {
    const cont = document.getElementById('incidentes');
    if (cont && cont.classList.contains('active')) {
        setTimeout(generarSiguienteCodigoIncidente, 100);
    }
});

observerIncidentes.observe(document.getElementById('incidentes'), { attributes: true, attributeFilter: ['class'] });

// Asegurar ejecución al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    generarSiguienteCodigoIncidente();
});

// SweetAlert para confirmar eliminación
function confirmarEliminacion(btn){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('form').submit();
        }
    });
}@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: '{{ session("success") }}',
    timer: 2500,
    showConfirmButton: false
});
@endif
</script>

        <!-- ACTIVIDADES DE PROCESAMIENTO ----------------------------------------------------------->
<div id="procesamiento" class="content-section">

    <h2 class="section-title">Registro de Actividades de Procesamiento</h2>
    <p style="margin-bottom: 20px; color: #666;">
        Inventario de todas las actividades de tratamiento de datos personales
    </p>

    @if ($errors->any())
        <div style="background-color: #f8d7da; 
                    color: #721c24; 
                    padding: 10px; 
                    border-radius: 5px; 
                    margin-bottom: 15px;">
            <strong>⚠ Debes corregir lo siguiente:</strong>
            <ul style="margin-top: 5px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("procesamiento").style.display = "block";
            });
        </script>
    @endif

    <form method="POST" action="{{ route('actividades.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label style="font-weight: 600;">Código de Actividad *</label>
    
                <div style="position: relative;">
                    <input type="text"
                        value="(Generado automáticamente)"
                        readonly
                        style="width: 100%;
                                padding: 10px 12px;
                                border: 1px solid #ccc;
                                border-radius: 6px;
                                background-color: #f5f7fa;
                                color: #555;
                                font-style: italic;">
        
                    <span style="position: absolute;
                                right: 10px;
                                top: 50%;
                                transform: translateY(-50%);
                                font-size: 12px;
                                color: #888;">
                        Auto
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Nombre de la Actividad *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}">
            </div>

            <div class="form-group">
                <label>Responsable *</label>
                <select name="responsable">
                    <option value="">Seleccionar responsable...</option>

                    @foreach($miembros as $miembro)
                        <option value="{{ $miembro->nombre_completo }}"
                            {{ old('responsable') == $miembro->nombre_completo ? 'selected' : '' }}>
                            {{ $miembro->nombre_completo }} - {{ $miembro->cedula }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Finalidad del Tratamiento *</label>
            <textarea name="finalidad" rows="3">{{ old('finalidad') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Base Legal *</label>
                <select name="base_legal">
                    <option value="">Seleccionar...</option>
                    <option value="consentimiento" {{ old('base_legal') == 'consentimiento' ? 'selected' : '' }}>Consentimiento</option>
                    <option value="contrato" {{ old('base_legal') == 'contrato' ? 'selected' : '' }}>Ejecución de Contrato</option>
                    <option value="legal" {{ old('base_legal') == 'legal' ? 'selected' : '' }}>Obligación Legal</option>
                    <option value="interes" {{ old('base_legal') == 'interes' ? 'selected' : '' }}>Interés Legítimo</option>
                </select>
            </div>

            <div class="form-group">
                <label>Categorías de Datos</label>
                <input type="text" name="categorias_datos" value="{{ old('categorias_datos') }}">
            </div>

            <div class="form-group">
                <label>Plazo de Conservación</label>
                <input type="text" name="plazo_conservacion" value="{{ old('plazo_conservacion') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Medidas de Seguridad</label>
            <textarea name="medidas_seguridad" rows="3">{{ old('medidas_seguridad') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Registrar Actividad
        </button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Actividad</th>
                    <th>Responsable</th>
                    <th>Base Legal</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @foreach($procesamientos ?? [] as $act)
                <tr>
                    <td>{{ $act->codigo }}</td>
                    <td>{{ $act->nombre }}</td>
                    <td>{{ $act->responsable }}</td>
                    <td>{{ $act->base_legal }}</td>
                    <td>
                        <span class="badge badge-success">{{ $act->estado }}</span>
                    </td>
                    <td>
                        <button class="btn btn-secondary"
                                onclick="verActividad({{ $act->id }})">
                            Ver
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- PANEL VER ACTIVIDAD -->
        <div id="panelActividad" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.5); z-index:9999;">
            <div style="background:#fff; width:60%; margin:5% auto; padding:20px; border-radius:8px; max-height:80%; overflow:auto;">
                <h3>Detalle de la Actividad</h3>

                <p><strong>Código:</strong> <span id="v_codigo"></span></p>
                <p><strong>Nombre:</strong> <span id="v_nombre"></span></p>
                <p><strong>Responsable:</strong> <span id="v_responsable"></span></p>
                <p><strong>Finalidad:</strong> <span id="v_finalidad"></span></p>
                <p><strong>Base Legal:</strong> <span id="v_base_legal"></span></p>
                <p><strong>Categorías:</strong> <span id="v_categorias"></span></p>
                <p><strong>Plazo:</strong> <span id="v_plazo"></span></p>
                <p><strong>Medidas:</strong> <span id="v_medidas"></span></p>
                <p><strong>Estado:</strong> <span id="v_estado"></span></p>

                <button onclick="cerrarActividad()" class="btn btn-secondary">Cerrar</button>
            </div>
        </div>

    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {

        @if ($errors->any())
            activarModuloProcesamiento();
        @endif

        @if(session('success'))
            activarModuloProcesamiento();
        @endif

        function activarModuloProcesamiento() {
            // Oculta todas las secciones
            document.querySelectorAll('.content-section').forEach(function(section) {
                section.style.display = 'none';
            });

            // Muestra solo procesamiento
            var modulo = document.getElementById('procesamiento');
            if (modulo) {
                modulo.style.display = 'block';
            }
        }

    });
</script>

</div> 

<!-- AUDITORÍAS -->
<div id="auditorias" class="content-section">
    <h2 class="section-title">Gestión de Auditorías</h2>

    <form method="POST" action="{{ route('auditorias.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tipo de Auditoría *</label>
                <select name="tipo_aud" id="tipo_aud" required>
                    <option value="">Seleccionar...</option>
                    <option value="interna" {{ old('tipo_aud') == 'interna' ? 'selected' : '' }}>Interna</option>
                    <option value="externa" {{ old('tipo_aud') == 'externa' ? 'selected' : '' }}>Externa</option>
                </select>
            </div>
            <div class="form-group">
                <label>Auditor Responsable *</label>
                <select name="auditor_id" id="usuario_auditor_id" class="form-control" required>
                    <option value="">Seleccione un auditor</option>
                    @forelse($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" 
                                data-rol="{{ $usuario->rol }}"
                                data-estado="{{ $usuario->estado }}"
                                {{ old('auditor_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                        </option>
                    @empty
                        <option value="" disabled>No hay usuarios disponibles</option>
                    @endforelse
                </select>
                @error('auditor_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Inicio *</label>
                <div class="date-display" style="background-color: #f8f9fa; padding: 12px; border-radius: 4px; border: 1px solid #ced4da;">
                    <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong>
                    <input type="hidden" name="fecha_inicio" value="{{ date('Y-m-d') }}">
                </div>
                <small class="form-text text-muted">La fecha de inicio es automáticamente la fecha actual</small>
                @error('fecha_inicio')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Fecha de Finalización *</label>
                <!-- ✅ CAMBIADO: ahora es text, no date -->
                <input type="text" 
                       name="fecha_fin" 
                       id="fecha_fin"
                       required
                       placeholder="DD/MM/AAAA"
                       value="{{ old('fecha_fin', date('d/m/Y', strtotime('+1 day'))) }}"
                       maxlength="10"
                       class="form-control">
                <small class="form-text text-muted">Formato: DD/MM/AAAA (ej: 18/02/2026)</small>
                @error('fecha_fin')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Estado *</label>
                <select name="estado_aud" required>
                    <option value="planificada" {{ old('estado_aud') == 'planificada' ? 'selected' : '' }}>Planificada</option>
                    <option value="proceso" {{ old('estado_aud') == 'proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="completada" {{ old('estado_aud') == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="revisada" {{ old('estado_aud') == 'revisada' ? 'selected' : '' }}>Revisada</option>
                    <option value="cancelada" {{ old('estado_aud') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('estado_aud')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Alcance de la Auditoría</label>
            <textarea name="alcance" rows="3" placeholder="Describa el alcance de la auditoría...">{{ old('alcance') }}</textarea>
            @error('alcance')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Hallazgos y Observaciones</label>
            <textarea name="hallazgos" rows="4" placeholder="Registre los hallazgos encontrados...">{{ old('hallazgos') }}</textarea>
            @error('hallazgos')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Registrar Auditoría
        </button>
    </form>

    <!-- Resto del código de la tabla -->
</div>

<!-- ✅ AGREGAR MÁSCARA PARA FECHA -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para fecha
    if (typeof $.fn.mask !== 'undefined') {
        $('#fecha_fin').mask('00/00/0000');
    }
    
    // Tu código existente de filtrado
    const tipoAudSelect = document.getElementById('tipo_aud');
    const auditorSelect = document.getElementById('usuario_auditor_id');
    const todasLasOpciones = Array.from(auditorSelect.options).slice(1);
    
    function filtrarAuditores() {
        const tipoAud = tipoAudSelect.value;
        const valorSeleccionado = auditorSelect.value;
        
        auditorSelect.innerHTML = '<option value="">Seleccione un auditor</option>';
        
        if (!tipoAud) {
            return;
        }
        
        let opcionesFiltradas = todasLasOpciones.filter(opt => {
            if (tipoAud === 'interna') {
                return (opt.dataset.rol === 'auditor_interno' || opt.dataset.rol === 'auditor') 
                       && opt.dataset.estado === 'activo';
            } else if (tipoAud === 'externa') {
                return opt.dataset.rol === 'auditor_externo' 
                       && opt.dataset.estado === 'activo';
            }
            return false;
        });
        
        opcionesFiltradas.forEach(opt => {
            auditorSelect.appendChild(opt.cloneNode(true));
        });
        
        if (opcionesFiltradas.length === 0) {
            const noOption = document.createElement('option');
            noOption.value = '';
            noOption.disabled = true;
            noOption.selected = true;
            noOption.textContent = 'No hay auditores disponibles para este tipo';
            auditorSelect.appendChild(noOption);
        }
        
        if (valorSeleccionado) {
            const opcionSeleccionada = Array.from(auditorSelect.options).find(opt => opt.value === valorSeleccionado);
            if (opcionSeleccionada) {
                opcionSeleccionada.selected = true;
            }
        }
    }
    
    tipoAudSelect.addEventListener('change', filtrarAuditores);
    
    @if(old('tipo_aud'))
        tipoAudSelect.value = "{{ old('tipo_aud') }}";
        filtrarAuditores();
    @endif
});
</script>
<!-- ================= REPORTES ================= -->
<div id="reportes" class="content-section">
    <h2 class="section-title">Dashboard de Reportes y Estadísticas</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $sujetos->count() }}</h3>
            <p>Total Sujetos Registrados</p>
        </div>
        <div class="stat-card">
            <h3>{{ $consentimientos->where('estado','otorgado')->count() }}</h3>
            <p>Consentimientos Activos</p>
        </div>
        <div class="stat-card">
            <h3>{{ $dsars->count() }}</h3>
            <p>Solicitudes DSAR</p>
        </div>
        <div class="stat-card">
            <h3>{{ $incidentes->where('estado','abierto')->count() }}</h3>
            <p>Incidentes Abiertos</p>
        </div>
    </div>

    <!-- ===== DSAR PIE CHART ===== -->
    <div class="chart-container" style="max-width:480px; margin:30px auto;">
        <h3 style="color:#667eea; text-align:center;">
            📊 Distribución de Solicitudes DSAR
        </h3>
        <canvas id="dsarChart" height="110"></canvas>
    </div>

    <!-- ===== INCIDENTES BAR CHART ===== -->
    <div class="chart-container" style="max-width:600px; margin:40px auto;">
        <h3 style="color:#ef4444; text-align:center;">
            ⚠️ Incidentes por Severidad
        </h3>
        <canvas id="incidentesChart" height="100"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ================= DSAR PIE ================= */
const dsarLabels = [
@foreach($dsars->groupBy('tipo') as $tipo => $grupo)
    "{{ ucfirst($tipo) }}",
@endforeach
];

const dsarData = [
@foreach($dsars->groupBy('tipo') as $tipo => $grupo)
    {{ $grupo->count() }},
@endforeach
];

new Chart(document.getElementById('dsarChart'), {
    type: 'doughnut',
    data: {
        labels: dsarLabels,
        datasets: [{
            data: dsarData,
            backgroundColor: [
                '#6366f1',
                '#22c55e',
                '#f59e0b',
                '#ef4444',
                '#06b6d4'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 30,
                    padding: 15,
                    usePointStyle: true
                }
            }
        }
    }
});

/* ================= INCIDENTES BAR ================= */
const incidenteLabels = [
@foreach($incidentes->groupBy('severidad') as $sev => $grupo)
    "{{ ucfirst($sev) }}",
@endforeach
];

const incidenteData = [
@foreach($incidentes->groupBy('severidad') as $sev => $grupo)
    {{ $grupo->count() }},
@endforeach
];

new Chart(document.getElementById('incidentesChart'), {
    type: 'bar',
    data: {
        labels: incidenteLabels,
        datasets: [{
            data: incidenteData,
            backgroundColor: [
                '#22c55e',
                '#0ea5e9',
                '#f59e0b',
                '#ef4444'
            ],
            borderRadius: 20,
            maxBarThickness: 80,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>



<script>
    const csrf = "{{ csrf_token() }}";
</script>

<script>
    const actividades = @json($procesamientos);

    function verActividad(id) {
        const act = actividades.find(a => a.id === id);
        if (!act) return;

        document.getElementById('v_codigo').innerText = act.codigo;
        document.getElementById('v_nombre').innerText = act.nombre;
        document.getElementById('v_responsable').innerText = act.responsable;
        document.getElementById('v_finalidad').innerText = act.finalidad;
        document.getElementById('v_base_legal').innerText = act.base_legal;
        document.getElementById('v_categorias').innerText = act.categorias_datos;
        document.getElementById('v_plazo').innerText = act.plazo_conservacion;
        document.getElementById('v_medidas').innerText = act.medidas_seguridad;
        document.getElementById('v_estado').innerText = act.estado;

        document.getElementById('panelActividad').style.display = 'block';
    }

    function cerrarActividad() {
        document.getElementById('panelActividad').style.display = 'none';
    }
</script>

@if(session('swal'))
<script>
    Swal.fire({
        icon: "{{ session('swal.icon') }}",
        title: "{{ session('swal.title') }}",
        text: "{{ session('swal.text') }}",
        confirmButtonText: 'Aceptar'
    });
</script>
@endif
<script>
(() => {
    const channelName = 'coac_single_tab';
    const localStorageKey = 'coac_active_tab';
    const TAB_TAKEOVER_DELAY = 2000;

    let isMainTab = false;
    let modalShown = false;

    // =========================
    // Modal
    // =========================
    function showTabModal() {
        if (modalShown) return;
        modalShown = true;

        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        `;

        modal.innerHTML = `
            <div style="background:#fff;padding:25px;border-radius:10px;max-width:420px;width:90%;text-align:center">
                <p style="font-size:16px;margin-bottom:10px;">
                    <strong>El Sistema COAC está abierto en otra pestaña.</strong>
                </p>
                <p style="font-size:14px;margin-bottom:20px;">
                    Haz clic en <b>“Usar aquí”</b> para continuar en esta pestaña.
                </p>
                <button id="useHere"
                    style="padding:8px 16px;background:#16a34a;color:#fff;border:none;border-radius:5px;cursor:pointer;">
                    Usar aquí
                </button>
            </div>
        `;

        document.body.appendChild(modal);

        document.getElementById('useHere').onclick = () => {
            console.log('[TabControl] TAKE_OVER enviado');
            broadcastTakeOver();
            isMainTab = true;
            modal.remove();
            modalShown = false;
        };
    }

    // =========================
    // BroadcastChannel
    // =========================
    const hasBroadcastChannel = typeof BroadcastChannel === 'function';
    let channel = null;

    if (hasBroadcastChannel) {
        channel = new BroadcastChannel(channelName);
        console.log('[TabControl] BroadcastChannel activo:', channelName);

        channel.onmessage = (event) => {
            const { type } = event.data || {};
            console.log('[TabControl] Mensaje recibido:', type);

            switch (type) {
                case 'PING':
                    if (isMainTab) {
                        channel.postMessage({ type: 'ACTIVE_TAB' });
                    }
                    break;

                case 'ACTIVE_TAB':
                    if (!isMainTab) {
                        showTabModal();
                    }
                    break;

                case 'TAKE_OVER':
                    if (isMainTab) {
                        alert('Esta sesión fue tomada por otra pestaña.');
                        location.reload();
                    }
                    isMainTab = false;
                    break;
            }
        };

        channel.postMessage({ type: 'PING' });
    } else {
        // =========================
        // Fallback localStorage
        // =========================
        window.addEventListener('storage', (event) => {
            if (event.key === localStorageKey) {
                if (event.newValue !== sessionStorage.getItem('tabId')) {
                    showTabModal();
                    isMainTab = false;
                }
            }
        });
    }

    // =========================
    // Identidad de pestaña
    // =========================
    const tabId = crypto.randomUUID();
    sessionStorage.setItem('tabId', tabId);

    function declareMainTab() {
        isMainTab = true;
        console.log('[TabControl] Pestaña principal:', tabId);

        if (hasBroadcastChannel) {
            channel.postMessage({ type: 'ACTIVE_TAB' });
        } else {
            localStorage.setItem(localStorageKey, tabId);
        }
    }

    function broadcastTakeOver() {
        if (hasBroadcastChannel) {
            channel.postMessage({ type: 'TAKE_OVER' });
        }
        localStorage.setItem(localStorageKey, tabId);
    }

    // =========================
    // Auto-asignación si nadie responde
    // =========================
    setTimeout(() => {
        if (!isMainTab && !modalShown) {
            declareMainTab();
        }
    }, TAB_TAKEOVER_DELAY);

})();
</script>
