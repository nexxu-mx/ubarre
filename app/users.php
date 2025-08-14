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
	<title>Sencia App</title>
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
	<link rel="stylesheet" href="assets/css/next.min.css?v=<?php echo time();?>">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<style>
		.icon{
			fill: #fff; 
			width: 60px;
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
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Empleados</h3>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">+ Nuevo Usuario</div>
                </div>
                <form id="userForm">
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 50px;">
                        <div class="avatar avatar-xxl">
                            <img src="./assets/img/unknnow.png" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="name@example.com" required>
                                <label for="nombre">Nombre*</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="numero" name="numero" placeholder="name@example.com" required>
                                <label for="numero">Número*</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="email" class="form-control" id="mail" placeholder="name@example.com" required>
                                <label for="mail">Email*</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="cont" placeholder="name@example.com" required>
                                <label for="cont">Contraseña*</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="puesto" placeholder="name@example.com">
                                <label for="puesto">Puesto</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                  <input type="checkbox" name="value" value="prod" class="selectgroup-input" >
                                  <span class="selectgroup-button">Clases</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="checkbox" name="value" value="fin" class="selectgroup-input">
                                  <span class="selectgroup-button">Coaches/Disciplinas</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="checkbox" name="value" value="cte" class="selectgroup-input">
                                  <span class="selectgroup-button">Finanzas</span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="checkbox" name="value" value="admon" class="selectgroup-input">
                                  <span class="selectgroup-button">Administración</span>
                                </label>
                                <label class="selectgroup-item" style="display: none">
                                  <input type="checkbox" name="value" value="caja" class="selectgroup-input" checked="">
                                  <span class="selectgroup-button">Paquetes</span>
                                </label>
                               
                              </div>
                        </div>
                        
                    </div>
                    
                    
                    
                    
                    
                    <div >
                        <button class="btn btn-success" type="submit" style="width: 100%; margin-top: 100px;">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Registrar
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-body">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Activos</div>
                        
                    </div>
                    <div class="card-list py-4" id="lisemp">
                        
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
	<script src="assets/js/usuarios.js"></script>



	
</body>
</html>