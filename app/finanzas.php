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

	<!-- CSS Files -->
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/plugins.min.css">
	<link rel="stylesheet" href="./assets/css/next.min.css?v=<?php echo time();?>">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="./assets/css/demo.css">
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
            <!--transacciones-->
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Histórico</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Transacciones</div>
                            </div>
                            <div class="card-body">
                                
                                                <div class="table-responsive">
                                                    <table id="basic-datatables" class="display table table-striped table-hover" >
                                                        <thead>
                                                            <tr>
                                                                <th>No. Recibo</th>
                                                                <th>Cliente</th>
                                                                <th>Monto Cobrado (Recibido)</th>
                                                                <th>Créditos</th>
                                                                <th>Metodo</th>
                                                                <th>Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody>
                                                            
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            
                            </div>
                        </div>
                    </div>

                </div>
            </div>

			<!--egresos-->
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Egresos</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Registrar nuevo Egreso </div>
                            </div>
                            <form id="egreForm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="date" class="form-control" id="fecha" name="fecha" placeholder="name@example.com" required>
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="concepto" name="concepto" placeholder="name@example.com" required>
                                            <label for="concepto">Concepto</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="name@example.com" required>
                                            <label for="tipo">Tipo de Operación</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="monto" name="monto" placeholder="name@example.com" required>
                                            <label for="monto">Monto</label>
                                        </div>
                                    </div>

                                </div>
                                <div >
                                    <button class="btn btn-success" type="submit" style="width: 100%; margin-top: 10px;">
                                        <span class="btn-label">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        Registrar Movimiento
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="display: flex; justify-content: space-between; ">
                                <div class="card-title" id="tituloMes">Egresos de </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Hoy</button>
                                    <div class="dropdown-menu" >
                                    <a class="dropdown-item" id="1m">Mes Pasado</a>
                                    <a class="dropdown-item" id="2m">Hace Dos Meses</a>
                                    <a class="dropdown-item" id="3m">Hace Tres Meses</a>
                                    </div>                          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th>Fecha</th>
                                        <th>Concepto.</th>
                                        <th>Tipo</th>
                                        <th>Monto</th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="liseg">
                                    
                                    </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--finanzas-->
			
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Balance</h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Balance</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Histórico</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="multipleLineChart"></canvas>
									</div>
								</div>
							</div>
						</div>
                        </div>
                        <div class="card">
								<div class="card-header">
									<div class="card-title">Resumen</div>
								</div>
								<div class="card-body">
									<table class="table table-head-bg-success">
										<thead>
											<tr>
												<th scope="col">Ingresos</th>
												<th scope="col">Egresos</th>
												<th scope="col">Utilidad</th>
											</tr>
										</thead>
										<tbody>
                                        <td id="ing"></td>
										<td id="eg"></td>
										<td id="uti"></td>
											
										</tbody>
									</table>
									
								</div>
							</div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">Operaciones del mes.</div>
                                            </div>
                                            <div class="card-body">
                                                <table class="table mt-3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Operación</th>
                                                                            <th scope="col">Concepto</th>
                                                                            <th scope="col">Monto</th>
                                                                            <th scope="col">Fecha</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                       
                                                                    </tbody>
                                                                </table>
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

	<script src="./assets/js/finanzas.js?v=<?php echo time(); ?>"></script>
	
</body>
</html>