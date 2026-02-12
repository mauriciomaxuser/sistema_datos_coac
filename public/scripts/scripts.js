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
        // PARA EDITAR USUARIO ----------------------------------------------
function editarUsuario(id, nombre, apellido, email, cedula, provincia, ciudad, direccion, rol) {
    Swal.fire({
        icon: 'info',
        title: 'Editar usuario',
        text: 'El formulario ha entrado en modo edición'
    });

    // Rellenar los campos del formulario
    $('#usuario_id').val(id);
    $('#nombre').val(nombre);
    $('#apellido').val(apellido);
    $('#cedula').val(cedula);
    $('#email').val(email);
    $('#provincia').val(provincia);
    $('#ciudad').val(ciudad);
    $('#direccion').val(direccion);
    $('#rol').val(rol);

    // Cambiar el método del formulario a PUT para edición
    $('#form_method').val('PUT');
    $('#formUsuarios').attr('action', '/usuarios/' + id);

    // Cambiar el texto del botón
    $('button[type="submit"]').text('Actualizar Usuario');
}





        //  EDITAR SUJETOS --------------------
        function editarSujeto(id, cedula, nombre, apellido, email, telefono, direccion, ciudad, provincia, tipo) {
    Swal.fire({
        icon: 'info',
        title: 'Editar Sujeto de datos',
        text: 'El formulario ha entrado en modo edición'
    });

    const form = document.getElementById('formSujetos');

    // Completar los inputs
    form.querySelector('input[name="cedula"]').value = cedula;
    form.querySelector('input[name="nombre"]').value = nombre;
    form.querySelector('input[name="apellido"]').value = apellido;
    form.querySelector('input[name="email"]').value = email;
    form.querySelector('input[name="telefono"]').value = telefono;
    form.querySelector('input[name="direccion"]').value = direccion;
    form.querySelector('input[name="ciudad"]').value = ciudad;
    form.querySelector('select[name="provincia"]').value = provincia;
    form.querySelector('select[name="tipo"]').value = tipo;

    // Asignar el id oculto
    document.getElementById('sujeto_id').value = id;

    // Cambiar el método a PUT
    document.getElementById('form_sujeto_method').value = 'PUT';

    // Actualizar la acción del formulario
    form.action = `/sujetos/${id}`;

    // Cambiar el texto del botón
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
    // Validación del formulario
// Validación del formulario
$("#formUsuarios").validate({
    rules: {
        nombre: {
            required: true,
            minlength: 3,
            soloLetras: true
        },
        apellido: {
            required: true,
            minlength: 3,
            soloLetras: true
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "/verificar-email",
                type: "get",
                data: {
                    email: function() { return $("#email").val(); },
                    id_usuario: function() { return $("#usuario_id").val(); } // Para editar
                }
            }
        },
        cedula: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 10,
            remote: {
                url: "/verificar-cedula",
                type: "get",
                data: {
                    cedula: function() { return $("#cedula").val(); },
                    id: function() { return $("#usuario_id").val(); } // Para editar
                }
            }
        },
        provincia: {
            required: true
        },
        ciudad: {
            required: true,
            minlength: 2
        },
        direccion: {
            required: true,
            minlength: 2
        },
        rol: {
            required: true
        }
    },
    messages: {
        nombre: {
            required: "El nombre es obligatorio",
            minlength: "Debe tener al menos 3 caracteres",
            soloLetras: "Solo se permiten letras"
        },
        apellido: {
            required: "El apellido es obligatorio",
            minlength: "Debe tener al menos 3 caracteres",
            soloLetras: "Solo se permiten letras"
        },
        email: {
            required: "El correo es obligatorio",
            email: "Correo no válido",
            remote: "Este correo ya está registrado"
        },
        cedula: {
            required: "La cédula es obligatoria",
            digits: "Solo se permiten números",
            minlength: "Debe tener 10 dígitos",
            maxlength: "Debe tener 10 dígitos",
            remote: "Esta cédula ya está registrada"
        },
        provincia: {
            required: "La provincia es obligatoria"
        },
        ciudad: {
            required: "La ciudad es obligatoria",
            minlength: "Debe tener al menos 2 caracteres"
        },
        direccion: {
            required: "La dirección es obligatoria",
            minlength: "Debe tener al menos 2 caracteres"
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


$(document).ready(function() {

    // Validación del formulario sujetos
    $("#formSujetos").validate({
        rules: {
            cedula: {
                required: true,
                minlength: 10,
                maxlength: 10,
                soloNumeros: true,
                remote: {
                    url: "/verificar-cedula-sujeto",
                    type: "get",
                    data: {
                        cedula: function() {
                            return $("#cedulaInput").val();
                        },
                        sujeto_id: function() {
                            return $("#sujeto_id").val();
                        }
                    }
                }
            },
            nombre: {
                required: true,
                minlength: 3,
                soloLetras: true
            },
            apellido: {
                required: true,
                minlength: 3,
                soloLetras: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "/verificar-email-sujeto",
                    type: "get",
                    data: {
                        email: function() { return $("#emailInput").val(); },
                        sujeto_id: function() { return $("#sujeto_id").val(); }
                    }
                }
            },
            telefono: {
                required: true,
                soloNumeros: true,
                minlength: 7,
                maxlength: 10
            },
            provincia: { required: true },
            ciudad: { required: true, minlength: 2 },
            direccion: { required: true, minlength: 2 },
            tipo: { required: true }
        },
        messages: {
            cedula: {
                required: "La cédula es obligatoria",
                minlength: "Debe tener 10 dígitos",
                maxlength: "Debe tener 10 dígitos",
                soloNumeros: "Solo se permiten números",
                remote: "Esta cédula ya está registrada"
            },
            nombre: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            apellido: {
                required: "El apellido es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                soloLetras: "Solo se permiten letras"
            },
            email: {
                required: "El email es obligatorio",
                email: "Correo no válido",
                remote: "Este correo ya está registrado"
            },
            telefono: {
                required: "El teléfono es obligatorio",
                soloNumeros: "Solo se permiten números",
                minlength: "Mínimo 7 dígitos",
                maxlength: "Máximo 10 dígitos"
            },
            provincia: { required: "Seleccione la provincia" },
            ciudad: {
                required: "La ciudad es obligatoria",
                minlength: "Debe tener al menos 2 caracteres"
            },
            direccion: {
                required: "La dirección es obligatoria",
                minlength: "Debe tener al menos 2 caracteres"
            },
            tipo: { required: "Seleccione el tipo de sujeto" }
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        }
    });

});
});

    // productos finacieros
    // ========== RESET FORMULARIO PRODUCTOS ==========
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

// ========== EDITAR PRODUCTO ==========
function editarProducto(id, codigo, nombre, tipo, descripcion, datos) {
    Swal.fire({
        icon: 'info',
        title: 'Editar producto financiero',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000,
        showConfirmButton: false
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
        
    },
    errorElement: "div",
    errorClass: "invalid-feedback",
    highlight: function (element) { $(element).addClass("is-invalid"); },
    unhighlight: function (element) { $(element).removeClass("is-invalid"); }
});



    



        
        
        





