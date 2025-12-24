        function showSection(sectionId) {
            // Ocultar todas las secciones
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            
            // Mostrar la sección seleccionada
            document.getElementById(sectionId).classList.add('active');
            
            // Actualizar botones activos
            const buttons = document.querySelectorAll('.nav-tabs button');
            buttons.forEach(button => {
                button.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        // reset formulario usuarios ------------------------
        function resetFormularioUsuarios() {
            $('#formUsuarios').attr('action', '/usuarios');
            $('#form_method').val('POST');
            $('#usuario_id').val('');

            $('#nombre_completo').val('');
            $('input[name="email"]').val('');
            $('#rol').val('');

            $('button[type="submit"]').text('Agregar Usuario');
        }


        
        //PARA EDITAR USUARIO ----------------------------------------------
        function editarUsuario(id, nombre, email, rol) {
            Swal.fire({
                icon: 'info',
                title: 'Editar usuario',
                text: 'El formulario ha entrado en modo edición'
            });

            $('#usuario_id').val(id);
            $('#nombre_completo').val(nombre);
            $('input[name="email"]').val(email);
            $('#rol').val(rol);

            $('#form_method').val('PUT');
            $('#formUsuarios').attr('action', '/usuarios/' + id);

            $('button[type="submit"]').text('Actualizar Usuario');
        }





        //  EDITAR SUJETOS --------------------
        function editarSujeto(id, cedula, nombre, email, telefono, direccion, tipo) {
            Swal.fire({
                icon: 'info',
                title: 'Editar Sujeto de datos',
                text: 'El formulario ha entrado en modo edición'
            });
            const form = document.getElementById('formSujetos');

            form.querySelector('input[name="cedula"]').value = cedula;
            form.querySelector('input[name="nombre"]').value = nombre;
            form.querySelector('input[name="email"]').value = email;
            form.querySelector('input[name="telefono"]').value = telefono;
            form.querySelector('input[name="direccion"]').value = direccion;
            form.querySelector('select[name="tipo"]').value = tipo;

            document.getElementById('sujeto_id').value = id;

            // Cambiar el método a PUT
            document.getElementById('form_sujeto_method').value = 'PUT';

            form.action = `/sujetos/${id}`;
            form.querySelector('button[type="submit"]').innerText = 'Actualizar Sujeto';
        }

        // mensaje unico de eliminar para sujetos y usuarios------------------------
            function confirmarEliminacion(boton) {
        event.preventDefault();

        const form = boton.closest('form');

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
    // funcion para resetear formulario de usuarios---------
    function resetFormularioUsuarios() {
    const form = $('#formUsuarios');

    form.attr('action', '/usuarios');
    $('#form_method').val('POST');
    $('#usuario_id').val('');

    $('#nombre_completo').val('');
    $('input[name="email"]').val('');
    $('#rol').val('');

    form.find('button[type="submit"]').text('Agregar Usuario');

    // quitar errores visuales
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}





        
    $(document).ready(function () {

    /* ===== MÉTODOS PERSONALIZADOS ===== */
    $.validator.addMethod("soloLetras", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
    }, "Solo se permiten letras");

    $.validator.addMethod("soloNumeros", function (value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "Solo se permiten números");

    // validaciones usuarioss--------------------------------
    $("#formUsuarios").validate({
        rules: {
            nombre_completo: {
                required: true,
                minlength: 3,
                soloLetras: true
            },
            email: {
                required: true,
                email: true
            },
            rol: {
                required: true
            }
        },
        messages: {
            nombre_completo: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            email: {
                required: "El correo es obligatorio",
                email: "Correo no válido"
            },
            rol: {
                required: "El rol es obligatorio"
            }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        }
    });

    // validaciones sujetoss ---------------------------------------
    $("#formSujetos").validate({
        rules: {
            cedula: {
                required: true,
                minlength: 10,
                maxlength: 10,
                soloNumeros: true
            },
            nombre: {
                required: true,
                minlength: 3,
                soloLetras: true
            },
            email: {
                email: true
            },
            telefono: {
                soloNumeros: true,
                minlength: 7,
                maxlength: 10
            },
            tipo: {
                required: true
            }
        },
        messages: {
            cedula: {
                required: "La cédula es obligatoria",
                minlength: "Debe tener 10 dígitos",
                maxlength: "Debe tener 10 dígitos",
                soloNumeros: "Solo se permiten números"
            },
            nombre: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            email: {
                email: "Correo no válido"
            },
            telefono: {
                soloNumeros: "Solo se permiten números",
                minlength: "Mínimo 7 dígitos",
                maxlength: "Máximo 10 dígitos"
            },
            tipo: {
                required: "Seleccione el tipo de sujeto"
            }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        }
    });
});
    // productos finacieros
    // ========== MOSTRAR SECCIONES ==========
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));
    
    document.getElementById(sectionId).classList.add('active');
    
    const buttons = document.querySelectorAll('.nav-tabs button');
    buttons.forEach(button => button.classList.remove('active'));
    event.target.classList.add('active');
}

// ========== RESET FORMULARIOS ==========
function resetFormularioUsuarios() {
    const form = $('#formUsuarios');
    form.attr('action', '/usuarios');
    $('#form_method').val('POST');
    $('#usuario_id').val('');
    $('#nombre_completo').val('');
    $('input[name="email"]').val('');
    $('#rol').val('');
    form.find('button[type="submit"]').text('Agregar Usuario');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}

function resetFormularioProductos() {
    const form = $('#formProductos');
    form.attr('action', '/productos');
    $('#form_producto_method').val('POST');
    $('#producto_id').val('');
    $('#producto_codigo').val('');
    $('#producto_nombre').val('');
    $('#producto_tipo').val('');
    $('#producto_descripcion').val('');
    $('#producto_datos').val('');
    form.find('button[type="submit"]').text('Guardar Producto');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}

// ========== EDITAR USUARIO ==========
function editarUsuario(id, nombre, email, rol) {
    Swal.fire({
        icon: 'info',
        title: 'Editar usuario',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000
    });

    $('#usuario_id').val(id);
    $('#nombre_completo').val(nombre);
    $('input[name="email"]').val(email);
    $('#rol').val(rol);
    $('#form_method').val('PUT');
    $('#formUsuarios').attr('action', '/usuarios/' + id);
    $('#formUsuarios button[type="submit"]').text('Actualizar Usuario');
}

// ========== EDITAR SUJETO ==========
function editarSujeto(id, cedula, nombre, email, telefono, direccion, tipo) {
    Swal.fire({
        icon: 'info',
        title: 'Editar Sujeto de datos',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000
    });
    
    const form = document.getElementById('formSujetos');
    form.querySelector('input[name="cedula"]').value = cedula;
    form.querySelector('input[name="nombre"]').value = nombre;
    form.querySelector('input[name="email"]').value = email;
    form.querySelector('input[name="telefono"]').value = telefono;
    form.querySelector('input[name="direccion"]').value = direccion;
    form.querySelector('select[name="tipo"]').value = tipo;
    document.getElementById('sujeto_id').value = id;
    document.getElementById('form_sujeto_method').value = 'PUT';
    form.action = `/sujetos/${id}`;
    form.querySelector('button[type="submit"]').innerText = 'Actualizar Sujeto';
}

// ========== EDITAR PRODUCTO ==========
function editarProducto(id, codigo, nombre, tipo, descripcion, datos) {
    Swal.fire({
        icon: 'info',
        title: 'Editar producto financiero',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000
    });

    $('#producto_id').val(id);
    $('#producto_codigo').val(codigo);
    $('#producto_nombre').val(nombre);
    $('#producto_tipo').val(tipo);
    $('#producto_descripcion').val(descripcion || '');
    $('#producto_datos').val(datos || '');
    $('#form_producto_method').val('PUT');
    $('#formProductos').attr('action', '/productos/' + id);
    $('#formProductos button[type="submit"]').text('Actualizar Producto');
}

// ========== CONFIRMAR ELIMINACIÓN ==========
function confirmarEliminacion(boton) {
    event.preventDefault();
    const form = boton.closest('form');

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// ========== VALIDACIONES JQUERY ==========
$(document).ready(function () {

    // Métodos personalizados
    $.validator.addMethod("soloLetras", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
    }, "Solo se permiten letras");

    $.validator.addMethod("soloNumeros", function (value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "Solo se permiten números");

    // VALIDACIÓN USUARIOS
    $("#formUsuarios").validate({
        rules: {
            nombre_completo: { required: true, minlength: 3, soloLetras: true },
            email: { required: true, email: true },
            rol: { required: true }
        },
        messages: {
            nombre_completo: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            email: { required: "El correo es obligatorio", email: "Correo no válido" },
            rol: { required: "El rol es obligatorio" }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function (element) { $(element).addClass("is-invalid"); },
        unhighlight: function (element) { $(element).removeClass("is-invalid"); }
    });

    // VALIDACIÓN SUJETOS
    $("#formSujetos").validate({
        rules: {
            cedula: { required: true, minlength: 10, maxlength: 10, soloNumeros: true },
            nombre: { required: true, minlength: 3, soloLetras: true },
            email: { email: true },
            telefono: { soloNumeros: true, minlength: 7, maxlength: 10 },
            tipo: { required: true }
        },
        messages: {
            cedula: {
                required: "La cédula es obligatoria",
                minlength: "Debe tener 10 dígitos",
                maxlength: "Debe tener 10 dígitos",
                soloNumeros: "Solo se permiten números"
            },
            nombre: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            email: { email: "Correo no válido" },
            telefono: {
                soloNumeros: "Solo se permiten números",
                minlength: "Mínimo 7 dígitos",
                maxlength: "Máximo 10 dígitos"
            },
            tipo: { required: "Seleccione el tipo de sujeto" }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function (element) { $(element).addClass("is-invalid"); },
        unhighlight: function (element) { $(element).removeClass("is-invalid"); }
    });

    // VALIDACIÓN PRODUCTOS FINANCIEROS
    $("#formProductos").validate({
        rules: {
            codigo: { required: true, minlength: 2 },
            nombre: { required: true, minlength: 3 },
            tipo: { required: true }
        },
        messages: {
            codigo: {
                required: "El código del producto es obligatorio",
                minlength: "Debe tener al menos 2 caracteres"
            },
            nombre: {
                required: "El nombre del producto es obligatorio",
                minlength: "Debe tener al menos 3 caracteres"
            },
            tipo: { required: "Seleccione el tipo de producto" }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function (element) { $(element).addClass("is-invalid"); },
        unhighlight: function (element) { $(element).removeClass("is-invalid"); }
    });
});




    



        
        
        





