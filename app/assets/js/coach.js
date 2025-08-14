$(document).ready(function() {
    $.ajax({
        url: 'get-coaches.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.message);
                $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los coaches</div></div>');
                return;
            }
            
            if (response.cursos.length === 0) {
                $('#cursos').html('<div class="col-12"><div class="alert alert-info">No hay coaches disponibles</div></div>');
                return;
            }
            
            // Generar las tarjetas de coaches
            var cursosHTML = '';
            
            response.cursos.forEach(function(curso) {
                
                cursosHTML += `<div class="col-md-4">
                        <div class="card card-profile">
                        <div class="card-header" style="background-image: url('${curso.imagen}')">
                            <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="${curso.imgau}" alt="..." class="avatar-img rounded-circle">
                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                            <div class="name">${curso.nombre}</div>
                            <div class="job">${curso.diciplina}</div>
                            <div class="desc">${curso.descripcion}</div>
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                <span class="btn-label just-icon"><i class="fab fa-whatsapp"></i> </span>
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="icon-social-facebook"></i>
                                </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                <span class="btn-label just-icon"><i class="icon-social-instagram"></i>
                                </span>
                                </a>
                            </div>
                            <div class="view-profile">
                                <a href="edit-coach.php?id=${curso.id}&9382nfcvomifnsv-c9q4infm-v59oin-v3590rij90ingvu3-0qi-3nf-9ovb-9" class="btn btn-secondary w-100 bg-secondary-gradient" >Ver Perfil</a>
                            </div>
                            </div>
                        </div>
                        
                        </div>
                    <div></div></div>`;
            });
            
            $('#cursos').html(cursosHTML);
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar cursos:", error);
            $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los coaches</div></div>');
        }
    });
});