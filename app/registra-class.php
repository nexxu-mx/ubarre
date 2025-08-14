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
	<link rel="icon" href="./favico.png" type="image/x-icon"/>
	<script src="./assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['./assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	 <!-- FullCalendar CSS -->
	 <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <!-- FullCalendar Locale (español) -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/plugins.min.css">
	<link rel="stylesheet" href="./assets/css/next.min.css?v=<?php echo time();?>">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="./assets/css/demo.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
	<style>
		 input { display: block; margin: 10px 0; padding: 8px; width: 250px; }
   .colso{
	display: none;
	position: fixed;
	z-index: 10000;
	top: 50%;
	left: 50%;
	padding:20px;
	transform: translate(-50%, -50%);
	width: 90%;
   }
   @media (min-width: 880px) {
		.colso{
			width: 30%;
		}
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
					<div class="row">
						<div class="col-md-12">
								<div class="card card-round">
									<div class="card-header">
										<div class="card-head-row">
											<div class="card-title">Regitro de Asistencia</div>
										</div>
									</div>
									<div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="reader" style="width:300px;"></div>
                                            </div>
                                            <div class="col-md-8">
                                                <form id="userForm">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Nombre</span>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" readonly aria-describedby="basic-addon3">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Clase</span>
                                                    <input type="text" class="form-control" id="clase" name="clase" readonly aria-describedby="basic-addon3">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Fecha y Hora</span>
                                                    <input type="text" class="form-control" id="inicia" name="inicia" readonly aria-describedby="basic-addon3">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Instructor</span>
                                                    <input type="text" class="form-control" id="instructor" name="instructor" readonly aria-describedby="basic-addon3">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">Duración</span>
                                                    <input type="text" class="form-control" id="duracion" name="duracion" readonly aria-describedby="basic-addon3">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon3">No Invitados</span>
                                                    <input type="text" class="form-control" id="invitados" name="invitados" readonly aria-describedby="basic-addon3">
                                                </div>
                                               
                                               
                                                
                                                </form>
                                            </div>
                                        </div>
                                        

                                        
									</div>
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
						<a href="http://www.nexxu.mx"><img src="https://nexxu.mx/./assets/images/logo-n.svg" style="width: 80px;" alt=""></a>
					</div>				
				</div>
			</footer>
		</div>
		

	</div>
	<script src="./assets/js/core/jquery-3.7.1.min.js"></script>
	<script src="./assets/js/core/popper.min.js"></script>
	<script src="./assets/js/core/bootstrap.min.js"></script>
	<script src="./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<script src="./assets/js/plugin/chart.js/chart.min.js"></script>
	<script src="./assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script src="./assets/js/plugin/chart-circle/circles.min.js"></script>
	<script src="./assets/js/plugin/datatables/datatables.min.js"></script>
	<script src="./assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="./assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
	<script src="./assets/js/plugin/jsvectormap/world.js"></script>
	<script src="./assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="./assets/js/next.min.js"></script>

	<script>
        function classOk() {
            swal({
						title: "Acceso Registrado",
						text: "La asistencia se registro exitosamente.",
						icon: "success",
						buttons: {
							confirm: {
								text: "Aceptar",
								value: true,
								visible: true,
								className: "btn btn-success",
								closeModal: true
							}
						}
					});
        }
    function onScanSuccess(decodedText, decodedResult) {
      console.log("Texto leído:", decodedText);

      // Enviar cadena completa al PHP
      fetch("get_user_qr.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ cadena: decodedText }) // <-- aquí va la cadena entera
      })
      .then(response => response.json())
      .then(asisten => {
        if (asisten && asisten.name) {
            document.getElementById("nombre").value = asisten.name;
            document.getElementById("clase").value = asisten.clase;
            document.getElementById("duracion").value = asisten.duracion;
            document.getElementById("instructor").value = asisten.instructor;
            document.getElementById("invitados").value = asisten.invitados;
            document.getElementById("inicia").value = asisten.inicia;
            classOk();
        } else {
            alert(asisten.error || "Usuario no encontrado");
        }
        })

      .catch(err => {
        console.error("Error al consultar usuario:", err);
      });

      // Detiene la cámara tras escaneo
      html5QrcodeScanner.clear().then(() => {
        // Esperar 10 segundos antes de volver a activar el escáner
        setTimeout(() => {
            html5QrcodeScanner.render(onScanSuccess);
        }, 10000); // 10000 ms = 10 segundos
        });

    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "reader",
      { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);
  </script>
</body>
</html>