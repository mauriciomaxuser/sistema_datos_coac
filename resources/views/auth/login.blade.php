<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema COAC | Inicio de Sesión</title>
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/estilos_login.css') }}">
</head>
<body class="login-body">

<div class="login-wrapper">

    <!-- PANEL INFORMATIVO -->
    <aside class="info-panel">
        <img src="{{ asset('images/coac.png') }}" alt="Urco Seguros"  class="info-image">

        <h2>SISTEMA COAC</h2>

        <p>
            <strong>Responsable del tratamiento:</strong><br>
            Agencia Asesora Productora de Seguros CIA Ltda / 
            Asesores de Seguros
        </p>

        <p>
            Productos especializados y asistencia <strong>24/7</strong> frente a siniestros.
            Atención personalizada las <strong>24 horas, 7 días</strong> a la semana y en cualquier lugar.
        </p>

        <p>
            Más de <strong>11 años</strong> en el mercado.<br>
            Cotiza con nosotros
        </p>

        <hr>

        <small>
            <strong>Base legal:</strong> Ley Orgánica de Protección de Datos Personales (LOPDP),
            su Reglamento General y resoluciones de la Superintendencia de Protección de Datos Personales (SPD).
        </small>

        <small>
            <strong>Derecho ejercido:</strong> Actualización – Art. 22 LOPDP.<br>
            <strong>Tiempo de respuesta:</strong> hasta 15 días, prorrogables por 5 días
            (Art. 66 del Reglamento General).
        </small>
    </aside>

    <!-- LOGIN -->
    <main class="login-panel">
        <h2>Iniciar sesión</h2>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
                @error('email') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
                @error('password') <small class="error">{{ $message }}</small> @enderror
            </div>
            
            <a href="{{ route('password.request') }}" class="forgot-link">
                ¿Olvidaste tu contraseña?
            </a>

            <button type="submit" class="btn btn-primary">
                Ingresar
            </button>
            <!-- Botón/Enlace Olvidaste tu contraseña -->
        <div class="forgot-password">
            <a >¿Olvidaste tu contraseña?</a>
        </div>
        </form>
    </main>

</div>

<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- EXITO --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Operación exitosa',
    text: "{{ session('success') }}",
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Continuar'
});
</script>
@endif

{{-- ERROR --}}
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Ocurrió un problema',
    text: "{{ session('error') }}",
    confirmButtonColor: '#d33'
});
</script>
@endif

{{-- VALIDACIONES --}}
@if($errors->any())
<script>
Swal.fire({
    icon: 'warning',
    title: 'Datos incorrectos',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#f59e0b'
});
</script>
@endif

</body>
</html>
