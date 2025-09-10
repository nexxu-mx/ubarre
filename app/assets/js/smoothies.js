$(document).ready(function () {
    $.ajax({
        url: 'get-smoothies.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            $('#smoothies-list').html('');

            if (response.error) {
                console.error(response.message);
                $('#smoothies').html('<div class="col-12"><div class="alert alert-danger">Error al cargar smoothies</div></div>');
                return;
            }

            if (response.smoothies.length === 0) {
                $('#smoothies').html('<div class="col-12"><div class="alert alert-info">No hay smoothies disponibles</div></div>');
                return;
            }

            // Generar las tarjetas de smoothies
            var smoothiesHTML = '';

            response.smoothies.forEach(function (smoothie) {
                smoothiesHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card card-post card-round">
                            <img class="card-img-top" src="${smoothie.imagen}" alt="${smoothie.sabor}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <div class="separator-solid"></div>
                                <h3 class="card-title text-center">
                                    ${smoothie.sabor}
                                </h3>
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="./alta-smoothie.php?id=${smoothie.id}" class="btn btn-primary btn-rounded btn-sm me-2"><i class="far fa-edit"></i> Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#smoothies-list').html(smoothiesHTML);

            // Agregar funcionalidad de eliminación
            $('.delete-smoothie').click(function () {
                var smoothieId = $(this).data('id');
                eliminarSmoothie(smoothieId);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar smoothies:", error);
            $('#smoothies-list').html('<div class="col-12"><div class="alert alert-danger">Error al cargar smoothies</div></div>');
        }
    });
});

// Función para eliminar smoothie directamente sin confirmación
function eliminarSmoothie(id) {
    $.ajax({
        url: 'eliminar-smoothie.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            var result = JSON.parse(response);
            if (result.success) {
                // Recargar la página después de eliminar
                location.reload();
            } else {
                alert('Error al eliminar el smoothie: ' + result.message);
            }
        },
        error: function () {
            alert('Error de conexión al intentar eliminar el smoothie');
        }
    });
}