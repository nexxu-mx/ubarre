
function getPaquetes() {
    $.ajax({
        url: 'get-paquetes.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.error(response.message);
                $('#paquetes').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los paquetes</div></div>');
                return;
            }

            if (response.paquetes.length === 0) {
                $('#paquetes').html('<div class="col-12"><div class="alert alert-info">No hay paquetes disponibles</div></div>');
                return;
            }

            // Generar las tarjetas de cursos
            var paquetesHTML = '';

            response.paquetes.forEach(function (paquete) {
                paquetesHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card card-post card-round">
                            <div class="card-body">
                                
                                <div class="separator-solid"></div>
                                <h3 class="card-title">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#cursoModal${paquete.id}">${paquete.nombre}</a>
                                </h3>
                                <p class="card-text text-muted">${paquete.costo}</p>
                                <div class="d-flex justify-content-between">
                                    <a href="./alta-paquete.php?id=${paquete.id}" class="btn btn-primary btn-rounded btn-sm"><i class="far fa-edit"></i> Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#paquetes').html(paquetesHTML);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar paquetes:", error);
            $('#paquetes').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los paquetes</div></div>');
        }
    });
}
$(document).ready(function () {
    getPaquetes();
});

