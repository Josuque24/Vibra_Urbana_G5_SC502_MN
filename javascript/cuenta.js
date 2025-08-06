$(document).ready(function () {
    // Obtener datos del usuario
    $.ajax({
        url: 'obtener_datos_usuario.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#usuario').val(data.usuario);
        }
    });

    // Eliminar cuenta con confirmación
    $('#eliminar-cuenta').on('click', function () {
        if (confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: 'eliminar_usuario.php',
                type: 'POST',
                success: function () {
                    alert('Tu cuenta ha sido eliminada.');
                    window.location.href = 'login.php';
                },
                error: function () {
                    alert('Error al eliminar la cuenta.');
                }
            });
        }
    });


    // Guardar cambios
    $('#form-cuenta').submit(function (e) {
        e.preventDefault();

        const datos = {
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            usuario: $('#usuario').val(),
            contrasenia: $('#contrasenia').val()
        };

        $.ajax({
            url: 'actualizar_datos_usuario.php',
            type: 'POST',
            data: datos,
            success: function () {
                const exito = $("#alerta-exito");
                exito.text("Datos actualizados correctamente").removeClass("d-none").addClass("show");

                // Ocultar mensaje
                setTimeout(() => {
                    exito.addClass("d-none").removeClass("show");
                }, 5000);

                $('#contrasenia').val(''); // Limpiar el campo de contraseña por seguridad
            },
            error: function (xhr) {
                const alerta = $("#alerta-mensaje");

                if (xhr.status === 409) {
                    alerta.text(xhr.responseText).removeClass("d-none").addClass("show");

                } else {
                    alerta.text("Error inesperado: " + xhr.responseText).removeClass("d-none").addClass("show");
                }

                // Ocultar mensaje
                setTimeout(() => {
                    alerta.addClass("d-none").removeClass("show");
                }, 5000);
            }
        });
    });
});
