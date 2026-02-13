<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nueva contraseña</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
}

.card{
    background:white;
    color:#1e293b;
    width:420px;
    padding:35px;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
}

h2{text-align:center;margin-top:0}

.input-group{position:relative}

input{
    width:100%;
    padding:12px;
    margin-top:12px;
    border-radius:10px;
    border:1px solid #cbd5e1;
}

.toggle{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    font-size:13px;
    color:#64748b;
    user-select:none;
}

.msg{
    font-size:13px;
    margin-top:6px;
    font-weight:500;
}

.ok{color:#16a34a}
.bad{color:#dc2626}

button{
    width:100%;
    padding:12px;
    margin-top:18px;
    border:none;
    border-radius:10px;
    background:#16a34a;
    color:white;
    font-weight:600;
    cursor:pointer;
}

button:disabled{
    background:#94a3b8;
    cursor:not-allowed;
}

button:hover:not(:disabled){background:#15803d}

@media(max-width:420px){.card{width:90%;padding:25px}}
</style>
</head>

<body>

<div class="card">
    <h2>Nueva contraseña</h2>

    <form method="POST" action="{{ route('password.update') }}" id="formReset">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Nueva contraseña" required minlength="6">
            <span class="toggle" onclick="togglePass('password',this)">Ver</span>
        </div>

        <div class="input-group">
            <input type="password" id="confirm" name="password_confirmation" placeholder="Confirmar contraseña" required minlength="6">
            <span class="toggle" onclick="togglePass('confirm',this)">Ver</span>
        </div>

        <div id="msg" class="msg"></div>

        <button id="btn">Cambiar contraseña</button>
    </form>
</div>

<script>
const pass = document.getElementById('password');
const confirmPass = document.getElementById('confirm');
const msg = document.getElementById('msg');
const btn = document.getElementById('btn');

btn.disabled = true;

function validar(){
    if(pass.value.length < 6){
        msg.innerHTML = "La contraseña debe tener mínimo 6 caracteres";
        msg.className="msg bad";
        btn.disabled=true;
        return;
    }

    if(pass.value !== confirmPass.value){
        msg.innerHTML = "Las contraseñas no coinciden";
        msg.className="msg bad";
        btn.disabled=true;
        return;
    }

    msg.innerHTML = "✔ Las contraseñas coinciden";
    msg.className="msg ok";
    btn.disabled=false;
}

pass.addEventListener('input',validar);
confirmPass.addEventListener('input',validar);

function togglePass(id,el){
    const input=document.getElementById(id);
    if(input.type==="password"){
        input.type="text";
        el.innerText="Ocultar";
    }else{
        input.type="password";
        el.innerText="Ver";
    }
}
</script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Contraseña actualizada',
    text:"{{ session('success') }}"
}).then(()=>window.location="{{ route('login') }}");
</script>
@endif

@if(session('error'))
<script>
Swal.fire({icon:'error',title:'Error',text:"{{ session('error') }}"});
</script>
@endif

@if ($errors->any())
<script>
Swal.fire({icon:'error',title:'Errores',html:`{!! implode('<br>',$errors->all()) !!}`});
</script>
@endif

</body>
</html>
