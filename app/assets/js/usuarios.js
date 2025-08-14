
// Función para cargar la lista de empleados
function cargarEmpleados() {
    $.ajax({
        url: 'listar_empleados.php',
        type: 'GET',
        success: function(response) {
            const empleados = JSON.parse(response);
            const lisemp = $('#lisemp');
            lisemp.empty(); // Limpiar la lista antes de cargar los nuevos datos

            empleados.forEach(function (empleado) {
                // Crear el HTML para cada empleado
                const empleadoHTML = `
                    <div class="item-list" data-id="${empleado.id}">
                        <div class="avatar">
                            <img src="./assets/img/unknnow.png" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info-user ms-3">
                            <div class="username">${empleado.nombre}</div>
                            <div class="status">${empleado.puesto}</div>
                        </div>
                        <button class="btn btn-icon btn-link btn-danger op-8 eliminar-btn">
                            <i class="fas fa-ban"></i>
                        </button>
                    </div>
                `;
                lisemp.append(empleadoHTML);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar empleados: ", error);
        }
    });
}

// Cargar la lista de empleados al cargar la página
$(document).ready(function() {
    cargarEmpleados();
// Eliminar un empleado al hacer clic en el botón de eliminar
$('#lisemp').on('click', '.eliminar-btn', function () {
    const empleadoId = $(this).closest('.item-list').data('id');

    // Confirmar la eliminación con SweetAlert 1.x
    swal({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción.",
        icon: 'warning',
        buttons: {
            cancel: {
                text: 'Cancelar',
                value: null,
                visible: true,
                className: 'btn btn-primary',
                closeModal: true
            },
            confirm: {
                text: '¡Sí, eliminar!',
                value: true,
                visible: true,
                className: 'btn btn-danger',
                closeModal: true
            }
        }
    }).then((result) => {
        if (result) {
            // Enviar solicitud para eliminar el empleado
            $.ajax({
                url: 'eliminar_empleado.php',
                type: 'POST',
                data: { id: empleadoId },
                success: function(response) {
                    swal("Eliminado!", "El empleado ha sido eliminado.", "success");
                    cargarEmpleados(); // Recargar la lista de empleados
                },
                error: function(xhr, status, error) {
                    swal("Error!", "Hubo un problema al eliminar al empleado.", "error");
                }
            });
        }
    });
});


    // Manejo del formulario de registro
    $('#userForm').on('submit', function (e) {
        e.preventDefault(); // Prevenir el envío del formulario tradicional

        // Recolectar los datos del formulario
        const formData = {
            nombre: $('#nombre').val(),
            numero: $('#numero').val(),
            mail: $('#mail').val(),
            cont: $('#cont').val(),
            puesto: $('#puesto').val(),
            values: []  // Array para almacenar los valores seleccionados de los checkboxes
        };

        // Agregar valores de checkboxes seleccionados
        $('input[name="value"]:checked').each(function() {
            formData.values.push($(this).val());
        });

        // Enviar los datos con AJAX a un archivo PHP
        $.ajax({
            url: 'guardar_usuario.php',  // Ruta de tu archivo PHP
            type: 'POST',
            data: JSON.stringify(formData),  // Enviar los datos como JSON
            contentType: 'application/json',
            success: function(response) {
                console.log(response);

                document.getElementById('nombre').value = "";
                document.getElementById('numero').value = "";
                document.getElementById('mail').value = "";
                document.getElementById('cont').value = "";
                document.getElementById('puesto').value = "";

                cargarEmpleados(); // Recargar la lista de empleados
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al registrar el usuario');
                console.error(error);
            }
        });
    });
});
