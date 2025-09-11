<?php
session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

    header("Location: ../login.php");
    exit;  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SenciaApp</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../favicon.svg" type="image/x-icon"/>
	<script src="assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/plugins.min.css">
	<link rel="stylesheet" href="assets/css/next.min.css">
	<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<style>
		.icon{
			fill: #fff; 
			width: 60px;
		}
	
		#editor-container {
            height: 300px;
            margin-bottom: 20px;
        }
	</style>
</head>
<body>
	<div class="wrapper sidebar_minimize">
		<!-- Sidebar -->
		<?php include 'sidebar.php'; ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<?php include 'navbar.php'; ?>
			
			<div class="container">
				<div class="page-inner">
				    
					<div class="page-header">
                      <h3 class="fw-bold mb-3">Cursos</h3>
                      <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                          <a href="index.php">
                            <i class="icon-home"></i>
                          </a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="academy.php">Academy</a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Nuevo Curso</a>
                        </li>
                      </ul>
                    </div>

					<div class="row">
					    <div class="col-md-12">
					        <div class="card">
					            <div class="card-header">
                                    <div class="card-title">Nueva Disciplina</div>
                                </div>
                                  <form id="productoForm" enctype="multipart/form-data">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-12" style="display: flex; justify-content: center">
                                            <div id="imgp" style="display: flex; align-items: center; justify-content: center; overflow: hidden;"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3">
                                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="">
                                              <label for="nombre">Titulo</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-custom mb-3">
                                              <input type="text" class="form-control" id="autor" name="autor" placeholder="">
                                              <label for="autor">Autor</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-custom mb-3">
                                              <input type="text" class="form-control" id="costo" name="costo" placeholder="">
                                              <label for="costo">Costo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3">
                                              <input type="text" class="form-control"  id="infor" name="infor" placeholder="">
                                              <label for="infor">Resumen</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="image">Imagen o Portada</label>
                                              <input type="file" class="form-control-file" id="image" name="image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3">
                                              <input type="text" class="form-control" id="link" name="link" placeholder="">
                                              <label for="link">Link del Curso</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                
                                            <h5>Descripción</h5>
                                            <input type="hidden" name="descripcion" id="descripcion">
                                            <div id="editor-container"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" type="submit">Guardar</button>
                                    <a href="academy.php" class="btn btn-danger">Cancelar</a>
                                  </div>
					        </div>
                            </form>
                            
                            
					    </div>
					</div>
				
				
				</div>
			</div>
			
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<a class="nav-link" href="http://www.nexxu.mx">
									Soporte
								</a>
							</li>
							
						</ul>
					</nav>
					<div class="copyright ms-auto">
						<a href="http://www.nexxu.mx"><img src="https://nexxu.mx/assets/images/logo-n.svg" style="width: 80px;" alt=""></a>
					</div>				
				</div>
			</footer>
		</div>
		

	</div>
	<script src="assets/js/core/jquery-3.7.1.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

	<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="assets/js/next.min.js"></script>
	<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>


	<script>
	    // Función para mostrar la vista previa de la imagen seleccionada
function mostrarVistaPrevia() {
    const inputFile = document.getElementById('image');
    const previewDiv = document.getElementById('imgp');
    
    // Verifica si hay un archivo seleccionado
    if (inputFile.files && inputFile.files[0]) {
        const file = inputFile.files[0];
        const reader = new FileReader();

        // Cuando la imagen se carga, se establece en el div con id="imgp"
        reader.onload = function(e) {
            // Limpiar el contenido previo del div
            previewDiv.innerHTML = '';

            // Crear una imagen para mostrar la vista previa
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Vista previa de la imagen';
            img.style.maxWidth = '100%'; // Ajusta el tamaño según sea necesario
            img.style.maxHeight = '200px'; // Limita la altura de la imagen

            // Añadir la imagen al div
            previewDiv.appendChild(img);
        };

        // Leer el archivo como una URL de datos
        reader.readAsDataURL(file);
    } else {
        previewDiv.innerHTML = 'No se ha seleccionado ninguna imagen.';
    }
}

// Asociar la función al evento change del input de archivo
document.getElementById('image').addEventListener('change', mostrarVistaPrevia);

	    // Inicializar Quill (editor de texto enriquecido)
var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],
    ['link', 'image', 'video', 'formula'],
  
    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtl' }],                         // text direction
  
    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  
    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': [] }],
    [{ 'align': [] }],
  
    ['clean']                                         // remove formatting button
  ];

var quill1 = new Quill('#editor-container', {
    placeholder: 'Escribe la descripción del producto aquí...',
    theme: 'snow',
      modules: {
    toolbar: toolbarOptions
  },
});


// Enviar el formulario manualmente
$(document).ready(function () {
    $('#productoForm').on('submit', function (event) {

        event.preventDefault(); // Evita la recarga de la página
        const content = quill1.root.innerHTML; // Obtener el contenido del editor en HTML
        document.querySelector('#descripcion').value = content;
        // Crear un objeto FormData y agregar el formulario completo
        var formData = new FormData(this);

        // Agregar los archivos de Dropzone al FormData
      
        // Envío AJAX al servidor
        $.ajax({
            url: 'guardar-curso.php', // Archivo PHP que procesará los datos
            type: 'POST',
            data: formData,
            contentType: false, // Necesario para enviar datos con FormData
            processData: false, // Evita que jQuery procese los datos
            
            success: function (response) {
                    try {
                        var jsonResponse = JSON.parse(response); // Convertir a objeto JSON
                        console.log('Respuesta del servidor:', jsonResponse);
                
                        if (jsonResponse.status === 'success') { 
                            swal('Curso registrado de manera exitosa!', {
                                buttons: { confirm: { className: 'btn btn-success' } }
                            });
                
                            // Resetear el formulario y limpiar Quill
                            $('#productoForm')[0].reset();
                            quill1.setContents([]);
                        } else {
                            alert('Error al registrar el curso: ' + jsonResponse.status);
                        }
                    } catch (error) {
                        alert('Error al procesar la respuesta del servidor.');
                        console.error('Error parseando JSON:', error, response);
                    }
                },
            error: function () {
                alert('Hubo un error en la solicitud al servidor.');
            }
        });
    });
});
	</script>
	
</body>
</html>