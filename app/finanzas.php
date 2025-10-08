<?php
session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

    header("Location: ../login.php");
    exit;  
}
if((int)$_SESSION['tipoUser'] !== 3 && (int)$_SESSION['tipoUser'] !== 4){
	header("Location: ./index.php?s=" . $_SESSION['tipoUser']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>übarre</title>
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
        .egrd{
            display: none;
            position: fixed;
            z-index: 1004;
            width: 90%;
            max-width: 650px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .overl{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1003;
            background: #000000a1;
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

                    <div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Finanzas</h4>
								</div>
								<div class="card-body" id="reporte">
									<ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                                        <?php
                                        if ((int)$_SESSION['tipoUser'] == 4) {
                                            echo '
                                                <li class="nav-item submenu" role="presentation">
                                                    <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill" href="#line-contact" role="tab" aria-controls="pills-contact" aria-selected="true" tabindex="-1">Ingresos</a>
                                                </li>';
                                        }else{
                                            echo '
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link active" id="line-home-tab" data-bs-toggle="pill" href="#line-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                                                    </li>
                                                    
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link" id="line-transacciones-tab" data-bs-toggle="pill" href="#line-transacciones" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Transacciones</a>
                                                    </li>
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill" href="#line-profile" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Ventas</a>
                                                    </li>
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill" href="#line-contact" role="tab" aria-controls="pills-contact" aria-selected="false" tabindex="-1">Ingresos</a>
                                                    </li>
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link" id="line-egresos-tab" data-bs-toggle="pill" href="#line-egresos" role="tab" aria-controls="pills-contact" aria-selected="false" tabindex="-1">Egresos</a>
                                                    </li>
                                                    <li class="nav-item submenu" role="presentation">
                                                        <a class="nav-link" id="line-ocupacion-tab" data-bs-toggle="pill" href="#line-ocupacion" role="tab" aria-controls="pills-contact" aria-selected="false" tabindex="-1">Ocupación</a>
                                                    </li>';
                                        }
                                        ?>
										
									</ul>
									<div class="tab-content mt-3 mb-3" id="line-tabContent">
                                        <!-- home -->
										<div class="tab-pane fade  <?php if ((int)$_SESSION['tipoUser'] == 3) { echo 'active'; } ?> show" id="line-home" role="tabpanel" aria-labelledby="line-home-tab">
											<div class="card-header" style="display: flex; justify-content: space-between; ">
                                                <div class="card-title" id="tituloMeshome" style="text-transform: capitalize;"></div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-border" id="exportPDF">Exportar</button>
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Periodo</button>
                                                    <div class="dropdown-menu" >
                                                    <a class="dropdown-item balanc" id="0a">Actual</a>
                                                    <a class="dropdown-item balanc" id="1a">Mes Pasado</a>
                                                    <a class="dropdown-item balanc" id="2a">Hace Dos Meses</a>
                                                    <a class="dropdown-item balanc" id="3a">Hace Tres Meses</a>
                                                    </div>                          
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            
                                                        <table class="table mt-3">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"></th>
                                                                    <th scope="col"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><b>Ingresos (+)</b></td>
                                                                    <td id="ing"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Egresos (-)</b></td>
                                                                    <td id="eg"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-success"><b>Utilidad</b></td>
                                                                    <td id="uti"></td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                    <td>Ocupación (%)</td>
                                                                    <td id="ocupacion">33%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        </div>
                                                        <div class="col-md-6">
                                                            
                                                            <div class="chart-container">
                                                                <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-12">
                                                            <div class="card-header">
                                                                <div class="card-title">Ventas Históricas</div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="chart-container">
                                                                    <canvas id="multipleLineChart"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
                                        <!-- transacciones -->
                                         <div class="tab-pane <?php if ((int)$_SESSION['tipoUser'] == 4) { echo 'active'; } ?> fade" id="line-transacciones" role="tabpanel" aria-labelledby="line-contact-tab">
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-striped table-hover" >
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Descripción</th>
                                                                <th>Ingreso (+)</th>
                                                                <th>Egreso (-)</th>
                                                                <th>Saldo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="operaciones"></tbody>
                                                    </table>
                                                </div>            
                                            </div>
                                         </div>
                                        <!-- ventas -->
										<div class="tab-pane fade" id="line-profile" role="tabpanel" aria-labelledby="line-profile-tab">
											
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
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody>
                                                            
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>            
                                            </div>
										</div>
                                        <!-- ingresos -->
										<div class="tab-pane fade" id="line-contact" role="tabpanel" aria-labelledby="line-contact-tab">
											<div class="card-header" style="display: flex; justify-content: space-between; ">
                                                <div class="card-title" id="tituloMesIng" style="text-transform: capitalize;"></div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-border" onclick="newIng()">Registrar Ingreso</button>
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Periodo</button>
                                                    <div class="dropdown-menu" >
                                                    <a class="dropdown-item dig" id="0i">Actual</a>
                                                    <a class="dropdown-item dig" id="1i">Mes Pasado</a>
                                                    <a class="dropdown-item dig" id="2i">Hace Dos Meses</a>
                                                    <a class="dropdown-item dig" id="3i">Hace Tres Meses</a>
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
                                                    <tbody id="lisig">
                                                    
                                                    </tbody>
                                                    </table>
                                                </div>
                                                
                                            </div>
										</div>
                                        <!-- Egresos -->
                                        <div class="tab-pane fade" id="line-egresos" role="tabpanel" aria-labelledby="line-contact-tab">
											<div class="card-header" style="display: flex; justify-content: space-between; ">
                                                <div class="card-title" id="tituloMes" style="text-transform: capitalize;"></div>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-border" onclick="newEgr()">Registrar Egreso</button>
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Periodo</button>
                                                    <div class="dropdown-menu" >
                                                    <a class="dropdown-item deg" id="0m">Actual</a>
                                                    <a class="dropdown-item deg" id="1m">Mes Pasado</a>
                                                    <a class="dropdown-item deg" id="2m">Hace Dos Meses</a>
                                                    <a class="dropdown-item deg" id="3m">Hace Tres Meses</a>
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
                                                    <tbody id="liseg"></tbody>
                                                    </table>
                                                </div>
                                            </div>
										</div>
                                        <!-- Ocupación -->
                                        <div class="tab-pane fade" id="line-ocupacion" role="tabpanel" aria-labelledby="line-contact-tab">
											<div class="card-header" style="display: flex; justify-content: space-between; ">
                                                <div class="card-title" id="tituloMesOcupacion" style="text-transform: capitalize;"></div>
                                                <div class="btn-group">
                                                    <div class="dropdown">
                                                        <button type="button" id="btnPeriodo" class="btn btn-outline-secondary">Periodo</button>
                                                    </div>                        
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                    <thead>
                                                        <tr>
                                                        <th>Coach</th>
                                                        <th>Clases</th>
                                                        <th>Reservaciones</th>
                                                        <th>Asistencias</th>
                                                        <th>Horas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="liocup"></tbody>
                                                    </table>
                                                </div>
                                            </div>
										</div>


									</div>
								</div>
							</div>
						</div>


             <!-- popup detalle de ocupacion -->
            <div id="popupDetalle" class="modal" style="display:none;">
            <div class="modal-content" style="padding:20px; background:white; border-radius:8px; max-width:700px; margin:auto;">
                <span id="cerrarPopup" style="cursor:pointer; float:right; font-size:20px;">&times;</span>
                <h3 id="popupTitulo" style="text-align: center;"></h3>
                <div id="popupContenido"></div>
            </div>
            </div>

               
            

			<!--popup egresos-->
            <div class="overl" id="overl" onclick="closeF()"></div>
            <div class="egrd" id="newegr">
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
            </div>

                        <div class="egrd" id="newing">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Registrar nuevo Ingreso </div>
                                        </div>
                                        <form id="ingreForm">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="date" class="form-control" id="fechai" name="fecha" placeholder="name@example.com" required>
                                                        <label for="fecha">Fecha</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" class="form-control" id="conceptoi" name="concepto" placeholder="name@example.com" required>
                                                        <label for="concepto">Concepto</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" class="form-control" id="tipoi" name="tipo" placeholder="name@example.com" required>
                                                        <label for="tipo">Tipo de Operación</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" class="form-control" id="montoi" name="monto" placeholder="name@example.com" required>
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
                        </div>
            
            <!--finanzas-->
			
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
	<script src="./assets/js/finanzas.js?v=<?php echo time(); ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
document.getElementById("exportPDF").addEventListener("click", function() {
    const reporte = document.getElementById("reporte");

    const idsOcultos = [
        "line-home",
        "line-transacciones",
        "line-profile",
        "line-contact",
        "line-egresos",
        "line-ocupacion"
    ];

    // Guardar clases originales
    const clasesOriginales = {};
    idsOcultos.forEach(id => {
        const el = document.getElementById(id);
        if(el){
            clasesOriginales[id] = el.className;
            el.classList.add("active", "show");
        }
    });

    html2canvas(reporte, {useCORS:true, scale:2}).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
        
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = pdf.internal.pageSize.getHeight();

        const imgWidth = pdfWidth;
        const imgHeight = (canvas.height * pdfWidth) / canvas.width;

        let heightLeft = imgHeight;
        let position = 0;

        // Primera página
        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pdfHeight;

        // Páginas siguientes
        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pdfHeight;
        }

        pdf.save('reporte_finanzas.pdf');

        // Restaurar clases originales
        idsOcultos.forEach(id => {
            const el = document.getElementById(id);
            if(el){
                el.className = clasesOriginales[id];
            }
        });
    });
});
</script>



	
</body>
</html>