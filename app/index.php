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
				<div class="page-inner">
					
					<div class="row">
						<div class="row row-card-no-pd">
							<div class="col-sm-6 col-md-3">
							  <div class="card card-stats card-round">
								<div class="card-body">
								  <div class="row">
									<div class="col-5">
									  <div class="icon-big text-center">
										<i class="icon-eye text-warning"></i>
									  </div>
									</div>
									<div class="col-7 col-stats">
									  <div class="numbers">
										<p class="card-category">Reservaciones</p>
										<h4 class="card-title ca33" id="Ivisitas"></h4>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-sm-6 col-md-3">
							  <div class="card card-stats card-round">
								<div class="card-body">
								  <div class="row">
									<div class="col-5">
									  <div class="icon-big text-center">
										<i class="icon-people text-success"></i>
									  </div>
									</div>
									<div class="col-7 col-stats">
									  <div class="numbers">
										<p class="card-category">Clientes</p>
										<h4 class="card-title ca33" id="Ileads"></h4>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-sm-6 col-md-3">
							  <div class="card card-stats card-round">
								<div class="card-body">
								  <div class="row">
									<div class="col-5">
									  <div class="icon-big text-center">
										<i class="icon-handbag text-danger"></i>
									  </div>
									</div>
									<div class="col-7 col-stats">
									  <div class="numbers">
										<p class="card-category">Ventas</p>
										<h4 class="card-title ca33" id="Iclientes"></h4>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-sm-6 col-md-3">
							  <div class="card card-stats card-round">
								<div class="card-body">
								  <div class="row">
									<div class="col-5">
									  <div class="icon-big text-center">
										<i class="icon-briefcase text-primary"></i>
									  </div>
									</div>
									<div class="col-7 col-stats">
									  <div class="numbers">
										<p class="card-category">% Aforo</p>
										<h4 class="card-title ca33" id="Icyc"></h4>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						
						
						
						
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="card card-round">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Estadisticas de Ventas</div>
										<div class="card-tools">
											<a href="#" class="btn btn-label-success btn-round btn-sm me-2">
												<span class="btn-label">
													<i class="fa fa-pencil"></i>
												</span>
												Export
											</a>
											<a href="#" class="btn btn-label-info btn-round btn-sm">
												<span class="btn-label">
													<i class="fa fa-print"></i>
												</span>
												Print
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
    									<div class="chart-container">
    										<canvas id="lineChart"></canvas>
    									</div>
    							</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-round">
								<div class="card-body">
									<div class="card-head-row card-tools-still-right">
										<div class="card-title">Transacciones Recientes</div>
										
									</div>
									<div class="card-list py-4" id="leadsrec">
										
										
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

	<script src="./assets/js/index.js?v=<?php echo time(); ?>"></script>
	
</body>
</html>