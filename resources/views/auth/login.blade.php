<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/estilos_login.css') }}">

</head>
<body>

<div class="container" style="max-width: 400px; margin-top: 80px;">
    <h2>Iniciar sesión</h2>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
            @error('email') <small>{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
            @error('password') <small>{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Ingresar
        </button>
        <p style="margin-top:15px; text-align:center;">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Crear una cuenta</a>
        </p>
        
        

    </form>
</div>

</body>
</html>
