<!DOCTYPE html>
<html>
<head>
    <title>Verificación de correo</title>
</head>
<body>
    <h1>Hola {{ $usuario->nombre }} {{ $usuario->apellido }}</h1>
    <p>Gracias por registrarte en nuestro sistema.</p>
    <p>Haz clic en el siguiente enlace para verificar tu correo y activar tu cuenta:</p>
    <p><a href="{{ $url }}">Verificar correo</a></p>
    @if(!empty($password))
        <p>Tu contraseña es: <strong>{{ $password }}</strong></p>
    @endif
    <p>Si no solicitaste esta cuenta, ignora este correo.</p>
    <p>Gracias,<br>{{ config('app.name') }}</p>
</body>
</html>
