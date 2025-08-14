$(document).ready(function() {
    $.ajax({
        url: 'get-diciplinas.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.message);
                $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar disiplinas</div></div>');
                return;
            }
            
            if (response.cursos.length === 0) {
                $('#cursos').html('<div class="col-12"><div class="alert alert-info">No hay disiplinas disponibles</div></div>');
                return;
            }
            
            // Generar las tarjetas de cursos
            var cursosHTML = '';
            
            response.cursos.forEach(function(curso) {
                var imgAutor = "unknnow";
                if(curso.autor == "Diana González"){
                    imgAutor = "diana";
                } else if(curso.autor == "Michel Gómez"){
                    imgAutor = "michel";
                }
                cursosHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card card-post card-round">
                            <img class="card-img-top" src="${curso.imagen}" alt="${curso.nombre}">
                            <div class="card-body">
                                
                                <div class="separator-solid"></div>
                                <h3 class="card-title">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#cursoModal${curso.id}">${curso.nombre}</a>
                                </h3>
                                <p class="card-text text-muted">${curso.descripcion.substring(0, 100)}${curso.descripcion.length > 100 ? '...' : ''}</p>
                                <div class="d-flex justify-content-between">
                                    <a href="./alta-curso.php?id=${curso.id}" class="btn btn-primary btn-rounded btn-sm"><i class="far fa-edit"></i> Editar</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            $('#cursos').html(cursosHTML);
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar disiplinas:", error);
            $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar disiplinas</div></div>');
        }
    });
});