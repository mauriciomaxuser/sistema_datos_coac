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
        //SUJETOS DE DATOS Y USUARIOS----------------------------------------------------------------------
        //-------------------------------------------------------------------------------------------------
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

    //-----VALIDACIONES
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
    // productos finacieros----------------------------------------------------------------
    //-------------------------------------------------------------------------------------
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

// ========== RESETEAR FORMULARIO CONSENTIMIENTOS ==========
function resetFormularioConsentimientos() {
    const form = $('#formConsentimientos');
    form.attr('action', '/consentimientos');
    $('#form_consentimiento_method').val('POST');
    $('#consentimiento_id').val('');
    $('#consentimiento_sujeto_id').val('');
    $('#consentimiento_proposito').val('');
    $('#consentimiento_estado').val('');
    $('#consentimiento_fecha_otorgamiento').val('');
    $('#consentimiento_metodo').val('');
    $('#consentimiento_fecha_expiracion').val('');
    form.find('button[type="submit"]').text('Registrar Consentimiento');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}

// ========== EDITAR CONSENTIMIENTO ==========
function editarConsentimiento(id, sujeto_id, proposito, estado, fecha_otorgamiento, metodo, fecha_expiracion) {
    Swal.fire({
        icon: 'info',
        title: 'Editar consentimiento',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000
    });

    $('#consentimiento_id').val(id);
    $('#consentimiento_sujeto_id').val(sujeto_id);
    $('#consentimiento_proposito').val(proposito);
    $('#consentimiento_estado').val(estado);
    $('#consentimiento_fecha_otorgamiento').val(fecha_otorgamiento);
    $('#consentimiento_metodo').val(metodo);
    $('#consentimiento_fecha_expiracion').val(fecha_expiracion);
    $('#form_consentimiento_method').val('PUT');
    $('#formConsentimientos').attr('action', '/consentimientos/' + id);
    $('#formConsentimientos button[type="submit"]').text('Actualizar Consentimiento');
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

    // VALIDACIÓN PRODUCTOS FINANCIEROS---------------------------------------------
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
    // VALIDACIÓN MIEMBROS COAC ----------------------------------------------------
   // ========== FUNCIONES PARA MIEMBROS ==========

    // EDITAR MIEMBRO
    function editarMiembro(id, numero_socio, cedula, nombre, fecha_ingreso, categoria, aportacion) {
        Swal.fire({
            icon: 'info',
            title: 'Editar Miembro',
            text: 'El formulario ha entrado en modo edición'
        });

        $('#miembro_id').val(id);
        $('#miembro_numero_socio').val(numero_socio);
        $('#miembro_cedula').val(cedula);
        $('#miembro_nombre_completo').val(nombre);
        $('#miembro_fecha_ingreso').val(fecha_ingreso);
        $('#miembro_categoria').val(categoria);
        $('#miembro_aportacion').val(aportacion);

        $('#form_miembro_method').val('PUT');
        $('#formMiembros').attr('action', '/miembros/' + id);

        $('button[type="submit"]').text('Actualizar Miembro');
    }

    // RESET FORMULARIO MIEMBROS
    function resetFormularioMiembros() {
        $('#formMiembros').attr('action', '/miembros');
        $('#form_miembro_method').val('POST');
        $('#miembro_id').val('');

        $('#miembro_numero_socio').val('');
        $('#miembro_cedula').val('');
        $('#miembro_nombre_completo').val('');
        $('#miembro_fecha_ingreso').val('');
        $('#miembro_categoria').val('');
        $('#miembro_aportacion').val('');

        $('button[type="submit"]').text('Registrar Miembro');

        // quitar errores visuales
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    }

    // ========== VALIDACIÓN MIEMBROS ==========
    $(document).ready(function () {
        
        // VALIDACIÓN MIEMBROS
        $("#formMiembros").validate({
            rules: {
                numero_socio: {
                    required: true,
                    minlength: 3
                },
                cedula: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                nombre_completo: {
                    required: true,
                    minlength: 3
                },
                fecha_ingreso: {
                    required: true,
                    date: true
                },
                categoria: {
                    required: true
                },
                aportacion: {
                    number: true,
                    min: 0
                }
            },
            messages: {
                numero_socio: {
                    required: "El número de socio es obligatorio",
                    minlength: "Debe tener al menos 3 dígitos"
                },
                cedula: {
                    required: "La cédula es obligatoria",
                    minlength: "Debe tener 10 dígitos",
                    maxlength: "Debe tener 10 dígitos"
                },
                nombre_completo: {
                    required: "El nombre completo es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres"
                },
                fecha_ingreso: {
                    required: "La fecha de ingreso es obligatoria",
                    date: "Ingrese una fecha válida"
                },
                categoria: {
                    required: "Seleccione la categoría del miembro"
                },
                aportacion: {
                    number: "Ingrese un valor numérico válido",
                    min: "El valor no puede ser negativo"
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
    // VALIDACIÓN CONSENTIMIENTOS---------------------------------------------------
        $("#formConsentimientos").validate({
            rules: {
                sujeto_id: { required: true },
                proposito: { required: true },
                estado: { required: true },
                fecha_otorgamiento: { date: true },
                metodo: {},
                fecha_expiracion: { date: true }
            },
            messages: {
                sujeto_id: { required: "Seleccione un sujeto de datos" },
                proposito: { required: "Seleccione el propósito del tratamiento" },
                estado: { required: "Seleccione el estado del consentimiento" },
                fecha_otorgamiento: { date: "Ingrese una fecha válida" },
                fecha_expiracion: { date: "Ingrese una fecha válida" }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function (element) { $(element).addClass("is-invalid"); },
            unhighlight: function (element) { $(element).removeClass("is-invalid"); }
        });
    });
// solicitudes DSAR-----------------------------------------
window.editarDSAR = function (
    id,
    numero,
    cedula,
    tipo,
    descripcion,
    fechaSolicitud,
    fechaLimite,
    estado
) {
    Swal.fire({
        icon: 'info',
        title: 'Editar solicitud',
        text: 'El formulario ha entrado en modo edición',
        timer: 2000,
        showConfirmButton: false
    });

    const form = document.getElementById('formDSAR');

    form.action = `/dsar/${id}`;
    document.getElementById('form_dsar_method').value = 'PUT';

    document.getElementById('dsar_numero').value = numero;
    document.getElementById('dsar_cedula').value = cedula;
    document.getElementById('dsar_tipo').value = tipo;
    document.getElementById('dsar_descripcion').value = descripcion;
    document.getElementById('dsar_fecha_solicitud').value = fechaSolicitud;
    document.getElementById('dsar_fecha_limite').value = fechaLimite ?? '';
    document.getElementById('dsar_estado').value = estado;

    document.getElementById('btnDsarGuardar').innerText = 'Actualizar Solicitud';
};



window.resetFormularioDSAR = function () {
    const form = document.getElementById('formDSAR');
    form.reset();

    form.action = "/dsar";
    document.getElementById('form_dsar_method').value = 'POST';
    document.getElementById('btnDsarGuardar').innerText = 'Registrar Solicitud';
};


function confirmarEliminacion(button) {
    if (confirm('¿Está seguro de eliminar esta solicitud DSAR?')) {
        button.closest('form').submit();
    }
}
// ===== MÉTODOS PERSONALIZADOS =====
$.validator.addMethod("soloNumeros", function (value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
}, "Solo se permiten números");

$.validator.addMethod("soloLetras", function (value, element) {
    return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value);
}, "Solo se permiten letras");

// ===== VALIDACIÓN SOLICITUD DSAR =====
$(document).ready(function () {

    $("#formDSAR").validate({
        rules: {
            numero_solicitud: {
                required: true,
                minlength: 5,
                soloNumeros: true
            },
            cedula: {
                required: true
                
                
            },
            tipo: {
                required: true
            },
            descripcion: {
                required: true,
                minlength: 10,
                soloLetras: true
            },
            fecha_solicitud: {
                required: true,
                date: true
            },
            estado: {
                required: true
            }
        },
        messages: {
            numero_solicitud: {
                required: "El número de solicitud es obligatorio",
                minlength: "Debe tener al menos 5 dígitos",
                soloNumeros: "Solo se permiten números"
            },
            cedula: {
                required: "Seleccione un sujeto de datos"
            },
            tipo: {
                required: "Seleccione el tipo de solicitud"
            },
            descripcion: {
                required: "La descripción es obligatoria",
                minlength: "Debe tener al menos 10 caracteres",
                soloLetras: "Solo se permiten letras y espacios"
            },
            fecha_solicitud: {
                required: "La fecha de solicitud es obligatoria",
                date: "Fecha no válida"
            },
            estado: {
                required: "Seleccione el estado"
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
// mensaje de alerta
document.addEventListener('DOMContentLoaded', () => {
    if (window.__swalData) {
        Swal.fire({
            icon: window.__swalData.icon,
            title: window.__swalData.title,
            text: window.__swalData.text,
            confirmButtonText: 'OK'
        });
    }
});
function confirmarEliminarDSAR(btn) {
    Swal.fire({
        title: '¿Eliminar solicitud?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('form').submit();
        }
    });
}
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-editar-dsar')) {

        const b = e.target;

        editarDSAR(
            b.dataset.id,
            b.dataset.numero,
            b.dataset.cedula,
            b.dataset.tipo,
            b.dataset.descripcion,
            b.dataset.fecha,
            b.dataset.limite,
            b.dataset.estado
        );
    }
});




    



        
        
        





