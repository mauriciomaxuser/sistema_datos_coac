<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Recuperar contraseña</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family: 'Inter', Arial;
    background:#f4f6f9;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    margin:0;
}

.card{
    background:white;
    padding:35px;
    width:100%;
    max-width:400px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

h2{margin-bottom:10px}
p{color:#666;margin-bottom:20px}

input{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ddd;
    margin-bottom:15px;
}

button{
    width:100%;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

a{
    display:block;
    margin-top:15px;
    text-align:center;
    color:#2563eb;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="card">
    <h2>Recuperar contraseña</h2>
    <p>Ingresa tu correo y te enviaremos un enlace</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="correo@ejemplo.com" required>
        <button type="submit">Enviar enlace</button>
    </form>

    <a href="{{ route('login') }}">Volver al login</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SUCCESS --}}
@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Correo enviado',
    text:"{{ session('success') }}"
});
</script>
@endif

{{-- ERROR --}}
@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'Error',
    text:"{{ session('error') }}"
});
</script>
@endif

{{-- VALIDACIONES --}}
@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Oops...',
    html:`{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif

</body>
</html>
