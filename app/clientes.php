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
		
			<div class="container" style="position: relative">
			    
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header" style="position: relative">
									<h4 class="card-title">Clientes Registrados</h4>
									<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                						<div>
                							<h3 class="fw-bold mb-3"></h3>
                						</div>
                						<div class="ms-md-auto py-2 py-md-0">
                							<a href="edit-user.php" class="btn btn-primary btn-round"><i class="fas fa-plus"></i> Nuevo Cliente</a>
                						</div>
                					</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Teléfono</th>
													<th>Email</th>
													<th>Creditos</th>
													<th>Tipo</th>
												</tr>
											</thead>
											
											<tbody id="leadsrec"></tbody>
										</table>
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
	<script src="assets/js/plugin/chart.js/chart.min.js"></script>
	<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
	<script src="assets/js/plugin/datatables/datatables.min.js"></script>
	<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="assets/js/next.min.js"></script>

	
	<script>
		$(document).ready(function() {
    $.ajax({
        url: 'get-leads.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.message);
                return;
            }

            const data = response.leads.map(lead => {
                return [
                    `<a href="edit-user.php?id=${lead.id}">${lead.nombre_completo}</a>`,
                    lead.telefono,
                    lead.email,
                    lead.interes,
					lead.tipo
                ];
            });

            $('#basic-datatables').DataTable({
                data: data,
                columns: [
                    { title: "Nombre" },
                    { title: "Teléfono" },
                    { title: "Email" },
                    { title: "Créditos" },
					{ title: "Tipo" }
                ]
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar leads:", error);
        }
    });
});

		
		
		
	</script>
</body>
</html>