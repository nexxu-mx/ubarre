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
	<style>
		.icon{
			fill: #fff; 
			width: 60px;
		}
       
	   #calendar {
	 max-width: 900px;
	 margin: 40px auto;
   }
   .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active {
	   background-color: var(--fc-button-active-bg-color,#A16A5B);
	   border-color: var(--fc-button-active-border-color,#73534A);
   }
   .fc .fc-button-primary {
	   background-color: var(--fc-button-bg-color,#D7B094);
	   border-color: var(--fc-button-border-color,#C19C82);
   }
   .fc .fc-button-primary:hover, .fc .fc-button-primary:focus {
	   background-color: var(--fc-button-bg-color,#C49675);
	   border-color: var(--fc-button-border-color,#C1A794); 
   }
   .fc .fc-button-primary:disabled {
	   background-color: var(--fc-button-bg-color,#A16A5BC2);
	   border-color: var(--fc-button-border-color,#A16A5B);
   }
   .fc .fc-toolbar-title {
	 font-weight: 300;
   }
   *, ::before, ::after {
	   font-family: inherit;
   }
   .fc .fc-col-header-cell-cushion {
	   font-weight: 300;
   }
   .fc-daygrid-dot-event .fc-event-title {
	  font-weight: 400;
   }
   .fc .fc-list-event-dot {
	   border:5px solid #C19C82;
	   border: calc(var(--fc-list-event-dot-width,10px)/ 2) solid var(--fc-event-border-color,#7CD100);
   }
   .fc .fc-timegrid-axis-cushion {
	   font-size: 1rem;
   }
   .fc-direction-ltr .fc-list-day-side-text, .fc-direction-rtl .fc-list-day-text {
	   font-weight: 400;
   }
   .fc-daygrid-day-events{
	height: 64px;
	overflow: auto;
   }
   .fc-event-time{
	color: #000;
   }
   .fc-event-title{
	color: #BFA187;
	
   }
   .fc-daygrid-dot-event .fc-event-title {
	font-weight: 900;
   }
   .fc-daygrid-event{
	display: flex;
   }
   .add{
	color: #000;
   }
   .trahs{
	color: #000;
   }

   .add:hover, .add:focus{
	color: blue;
   }
   .trash:hover,.trash:focus{
	color: red;
   }
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
											<div class="card-title">Clases</div>
										</div>
									</div>
									<div class="card-body">
										<div id="calendar"></div>
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
		<div id="oves" onclick="closeEv()" style="display: none; position: fixed; top: 0px; width: 100%; z-index: 9999;left: 0;height: 100%;background: #00000052;"></div>
		<div id="eventoModal" class="card colso">
        <div class="modal-contentCal" id="modal-content" style="position: relative;">
            <div class="m1">
                <h2 id="modalTitulo" style="color: #986C5D; text-align: center;"></h2>
            </div>
            <div class="m2" style="padding: 20px;">
                <div class="m3">
                    <p class="m4" style="color: #BFA187;font-size: 14px;font-weight: 700;display: flex;align-items: center;gap: 6px;line-height: 1;margin-bottom: 0;"><i class="fas fa-user-alt"></i> <a href="#" id="modalInstructor" style="color: #BFA187;font-size: 19px;font-weight: 700;"></a></p>
                    <div style="display: flex;justify-content: space-between; border-bottom: 1px solid #c5c5c5;">
						<h4 style="display: flex;align-items: baseline;gap: 5px;font-size: 15px;line-height: 1;margin-bottom: -17px;"><i class="icon-clock" style="color: #636363"></i> <p id="modalDuracion" style="font-weight: 100;color: #636363;"></p></h4>
						<div class="aforo-container" style="display: flex;align-items: baseline;gap: 10px;">
							<i class="fas fa-users"></i>
							<p id="aforo"></p>
						</div>
					</div>
					<div class="m7" style="margin-top: 10px; border-bottom: 1px solid #c5c5c5;">
                            <div class="m8" style="display: flex;gap: 10px;">
                                <div style="border-right: 1px solid #c5c5c5;">
									<small>Inicia</small>
									<p id="modalInicio" style="font-size: 13px;"></p>
								</div>
								<div>
									<small>Termina</small>
									<p id="modalFin" style="font-size: 13px;"></p>
								</div>
                            </div>
                    </div>
                </div>
                <div id="alumnos" style="height: 100px;overflow: auto;margin-top: 10px; border-bottom: 1px solid #c5c5c5;"></div>
                <div id="add_alumnos" style="display: none;align-items: center;gap: 10px;margin-block: 20px; ">
                    <?php
                        include '../db.php'; // o el archivo donde tengas tu $conn
                        
                        $sql = "SELECT id, nombre, mail FROM users ORDER BY nombre ASC";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo '<select class="form-select" id="alumn-event" name="alumn-event">';
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nombre']) . '(' . htmlspecialchars($row['mail']) . ')</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<select class="form-select" id="alumn-event" name="alumn-event">';
                            echo '<option disabled selected>No hay alumnos disponibles</option>';
                            echo '</select>';
                        }
                    ?>
                        <input type="hidden" id="id-event" name="id-event">
                         <input type="hidden" id="disciplina-event" name="disciplina-event">
                          <input type="hidden" id="coach-event" name="coach-event">
                           <input type="hidden" id="duracion-event" name="duracion-event"> 
                            <input type="hidden" id="idcoach-event" name="idcoach-event">
                            
                        <button type="button" onclick="registrarReservaInterna()" class="btn btn-icon btn-round btn-info">
							<i class="fas fa-user-plus"></i>
						</button>
                </div>
                <div  id="buttonModal" style="display: flex; justify-content: space-between; margin-top: 20px"></div>
            </div>
        </div>
    </div>
	<div id="evento-form" class="card colso">
	<h3 style="color: #986C5D; text-align: center;">Agendar Clase</h3>
	<p id="fech" style="text-align: center;"></p>
		<form id="form-evento" style="height: 60vh;overflow: auto;">
			
			<div class="form-floating form-floating-custom mb-3">
				<select class="form-select" id="disciplina-select" required=""></select>
				<label for="disciplina-select">Disciplina</label>
			</div>
			<div class="form-floating form-floating-custom mb-3">
				<select class="form-select" id="coach-select" required=""></select>
				<label for="coach-select">Coach</label>
			</div>

			<div style="display: flex;justify-content: space-between;gap: 10px;">
			<div class="form-floating form-floating-custom mb-3" style="width: 50%;">
				<input type="time" class="form-control" id="hora-inicio" placeholder="name@example.com">
				<label for="hora-inicio">Hora de Inicio</label>
			</div>
			<div class="form-floating form-floating-custom mb-3" style="width: 50%;">
				<input type="time" class="form-control" id="hora-fin" placeholder="name@example.com">
				<label for="hora-fin">Hora fin</label>
			</div>
			</div>

            <div class="selectgroup selectgroup-pills" style="display: grid;margin-block: 15px;">
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="1" class="selectgroup-input">
                <span class="selectgroup-button">Lunes</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="2" class="selectgroup-input">
                <span class="selectgroup-button">Martes</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="3" class="selectgroup-input">
                <span class="selectgroup-button">Miércoles</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="4" class="selectgroup-input">
                <span class="selectgroup-button">Jueves</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="5" class="selectgroup-input">
                <span class="selectgroup-button">Viernes</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="6" class="selectgroup-input">
                <span class="selectgroup-button">Sábado</span>
              </label>
              <label class="selectgroup-item">
                <input type="checkbox" name="dayrepeat" value="0" class="selectgroup-input">
                <span class="selectgroup-button">Domingo</span>
              </label>
            </div>


			<div class="form-floating form-floating-custom mb-3">
				<select class="form-select" id="aforo-select" required="">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14" selected>14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					
					

				</select>
				<label for="aforo"><i class="fas fa-users"></i> Aforo</label>
			</div>
			
			
			<div style="display: flex;justify-content: space-between;">
				<button type="button" onclick="cerrarFormulario()" class="btn btn-danger">Cancelar</button>
				<button type="submit" class="btn btn-success">Crear</button>
			</div>
		</form>
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

	<script src="./assets/js/calendar.js?v=<?php echo time(); ?>"></script> 
	
</body>
</html>