<?php
session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

	header("Location: ../login.php");
	exit;
}

if((int)$_SESSION['tipoUser'] !== 3){
	header("Location: ./index.php?s=" . $_SESSION['tipoUser']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SATYA App</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="./favico.png" type="image/x-icon" />
	<script src="./assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Public Sans:300,400,500,600,700"]
			},
			custom: {
				"families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['./assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/plugins.min.css">
	<link rel="stylesheet" href="./assets/css/next.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="./assets/css/demo.css">
	<style>
		.icon {
			fill: #fff;
			width: 60px;
		}

		/* From Uiverse.io by guilhermeyohan */ 
		.checkbox-apple {
		position: relative;
		width: 50px;
		height: 25px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		}

		.checkbox-apple label {
		position: absolute;
		top: 0;
		left: 0;
		width: 50px;
		height: 25px;
		border-radius: 50px;
		background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
		cursor: pointer;
		transition: all 0.3s ease;
		}

		.checkbox-apple label:after {
		content: '';
		position: absolute;
		top: 1px;
		left: 1px;
		width: 23px;
		height: 23px;
		border-radius: 50%;
		background-color: #fff;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
		transition: all 0.3s ease;
		}

		.checkbox-apple input[type="checkbox"]:checked + label {
		background: linear-gradient(to bottom, #4cd964, #5de24e);
		}

		.checkbox-apple input[type="checkbox"]:checked + label:after {
		transform: translateX(25px);
		}

		.checkbox-apple label:hover {
		background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
		}

		.checkbox-apple label:hover:after {
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
		}
.yep {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}
.new-code-form{
    display: none;
    position: fixed;
    z-index: 1004;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
    .over{
        display: none;
        position: fixed;
        z-index: 1003;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0000005e;
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
						<h3 class="fw-bold mb-3">Códigos de Descuentos</h3>
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
								<a href="#">Códigos</a>
							</li>
						</ul>
					</div>
					<div id="curs">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
							<div>
								<h3 class="fw-bold mb-3"></h3>
							</div>
							<div class="ms-md-auto py-2 py-md-0">
								<a href="#" onclick="openFormD()" class="btn btn-primary btn-round"><i class="fas fa-plus"></i> Nuevo</a>
							</div>
						</div>
						<div class="row" id="paquetes">
							<!-- Los cursos se cargarán aquí automáticamente -->
							<div class="col-12 text-center my-5">
								<div class="spinner-border text-primary" role="status">
									<span class="visually-hidden">Cargando...</span>
								</div>
								<p>Cargando...</p>
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


    <!-- alta codigo de descuento -->
     <div class="over" onclick="closeFormD()" id="over"></div>
    <div class="new-code-form" id="new-code-form">
        <div class="card">
            <div class="card-header">
                    <h4>Nuevo código de descuento</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-custom mb-3">
                          <input type="text" id="codigo" class="form-control" id="floatingInput" placeholder="name@example.com" maxlength="10" required="">
                          <label for="floatingInput">Código</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-custom mb-3">
                          <input type="text" id="descuento" class="form-control" id="floatingInput" placeholder="name@example.com" maxlength="2" minlength="1" required="">
                          <label for="floatingInput">Descuento (%)</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-floating form-floating-custom mb-3">
                          <input type="date" id="finaliza" class="form-control" id="floatingInput" placeholder="name@example.com" required="">
                          <label for="floatingInput">Fecha de expiración</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-custom mb-3">
                          <select class="form-select" id="restriccion" required="">
                            <option value="1" selected="">Fundadores</option>
                            <option value="0">Ninguno</option>
                          </select>
                          <label for="restriccion">Restricción</label>
                        </div>
                    </div>
                </div>
            </div>
           <div class="card-action">
                    <button class="btn btn-success" onclick="submitFormD()">Crear</button>
                    <button class="btn btn-danger" onclick="closeFormD()">Cancelar</button>
            </div>
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
	<script src="./assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="./assets/js/next.min.js"></script>

	<script src="./assets/js/descuentos.js?v=<?php echo time(); ?>"></script>

</body>

</html>