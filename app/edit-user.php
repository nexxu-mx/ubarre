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
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header" style="display: flex;align-items: center;gap: 20px;">
                                  <a href="clientes.php"><i class="fas fa-arrow-left" style="font-size: 20px"></i></a>
									<h4 class="card-title">Cliente</h4>
								</div>
                                <?php
                            include '../db.php';
                            include '../error_log.php';

                            if (isset($_GET['id'])) {
                                $idUsr = $_GET['id'];
                                $profilePath = "../assets/images/profiles/" . $idUsr . ".png";
                                $defaultPath = "../assets/images/profiles/unknow.png";
                        
                                if (!file_exists($profilePath)) {
                                    $profilePath = $defaultPath;
                                }
                                $smt = $conn->prepare("SELECT iduser, tipoUser, nombre, apellido, mail, numero, pass, fecha_nacimiento, credit, venceCredit, fechaCredit, maxInvitados, claseBienvenida, activo FROM users WHERE id = ?");
                                $smt->bind_param("i", $idUsr);
                                $smt->execute();
                                $resultadosmt = $smt->get_result();

                                $fsmt = $resultadosmt->fetch_assoc();

                               
                                $nombre = $fsmt['nombre'];
                                $apellido = $fsmt['apellido'];
                                $mail = $fsmt['mail'];
                                $numero = $fsmt['numero'];
                                $pass = $fsmt['pass'];
                                $fechanacimiento = $fsmt['fecha_nacimiento'];
                                $formatoOriginal = DateTime::createFromFormat('d-m-Y', $fechanacimiento);
                                $fecha_nacimiento = $fsmt['fecha_nacimiento'];
                                $credit = $fsmt['credit'];
                                $credVenci = !empty($fsmt['fechaCredit']) ? date("Y-m-d", strtotime($fsmt['fechaCredit'])) : '';

                                
                                $iniciales = strtoupper(($nombre[0] ?? '').($apellido[0] ?? ''));
                                if (empty($iniciales)) $iniciales = 'NA';

                                if($fsmt['tipoUser'] == 1){
                                    $tipus = '<option value="' . $fsmt['tipoUser'] . ' " checked>Cliente</option>';
                                }elseif($fsmt['tipoUser'] == 2){
                                    $tipus = '<option value="' . $fsmt['tipoUser'] . ' " checked>Coach</option>';
                                }if($fsmt['tipoUser'] == 3){
                                    $tipus = '<option value="' . $fsmt['tipoUser'] . ' " checked>Administrador</option>';
                                }else{
                                    $tipus = "";
                                }
                                $btnPaq = '<button class="btn btn-black" type="button" onclick="openAp()">
                                                <span class="btn-label">
                                                    <i class="fa fa-archive"></i>
                                                </span>
                                                Paquete
                                            </button>
                                            ';

                                $paquete = "";
                                $elmusr = '<button class="btn btn-danger" style="margin-left: 10px;" type="button" onclick="eliminarUsuario(' . $idUsr . ')">
                                            <span class="btn-label">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                            Eliminar Usuario
                                        </button>';
                                //transacciones

                                $sqlT = "SELECT monto, creditos, idpago, fecha FROM transacciones WHERE user = ? ORDER BY fecha DESC LIMIT 10";
                                $stmtT = $conn->prepare($sqlT);
                                $stmtT->bind_param("i", $idUsr);
                                $stmtT->execute();
                                $resultT = $stmtT->get_result();

                                
                                $comprasHTML = '<div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row card-tools-still-right">
                                            <div class="card-title">Transacciones Recientes</div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="max-height: 50vh;overflow: auto;">
                                        <ol class="activity-feed">';

                                while ($rowT = $resultT->fetch_assoc()) {
                                $fechaT = date('M d', strtotime($rowT['fecha']));
                                $datetimeT = date('Y-m-d', strtotime($rowT['fecha']));
                                $montoT = number_format($rowT['monto'], 2);
                                $creditosT = htmlspecialchars($rowT['creditos']);
                                $idpagoT = htmlspecialchars($rowT['idpago']);

                                $comprasHTML .= "
                                    <li class=\"feed-item feed-item-secondary\">
                                        <time class=\"date\" datetime=\"$datetimeT\">$fechaT</time>
                                        <span class=\"text\">
                                            Compra registrada por \$$montoT con $creditosT créditos (ID: $idpagoT)
                                        </span>
                                    </li>";
                                }

                                $comprasHTML .= '</ol>
                                    </div>
                                </div>
                                </div>';
                                //movimientos
                                
                                $movimientos_html = '<div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="card-head-row">
                                                                    <div class="card-title">Movimientos</div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body" style="max-height: 50vh;overflow: auto;">';

                                // --- CONSULTA RESERVAS ---
                                $reservas = $conn->prepare("SELECT clase, invitado, inicio FROM reservaciones WHERE alumno = ? ORDER BY fechaReserva DESC");
                                $reservas->bind_param("i", $idUsr);
                                $reservas->execute();
                                $res_result = $reservas->get_result();

                                while ($row = $res_result->fetch_assoc()) {
                                    $fecha = date('d \d\e F Y h:i A', strtotime($row['inicio']));
                                    $movimientos_html .= '
                                        <div class="d-flex">
                                            <div class="avatar avatar-online">
                                                <span class="avatar-title rounded-circle border border-white bg-info">' . $iniciales . '</span>
                                            </div>
                                            <div class="flex-1 ms-3 pt-1">
                                                <h6 class="text-uppercase fw-bold mb-1">' . htmlspecialchars($row['clase']) . ' <span class="text-success ps-3">Reserva</span></h6>
                                                <span class="text-muted">' . $fecha . '</span>
                                            </div>
                                            <div class="float-end pt-1">
                                                <small class="text-muted">-1</small>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>';
                                }

                                // --- CONSULTA COMPRAS ---
                                $compras = $conn->prepare("SELECT creditos, fecha, monto FROM transacciones WHERE user = ? ORDER BY fecha DESC");
                                $compras->bind_param("i", $idUsr);
                                $compras->execute();
                                $comp_result = $compras->get_result();

                                while ($row = $comp_result->fetch_assoc()) {
                                    $fecha = date('d \d\e F Y h:i A', strtotime($row['fecha']));
                                    $movimientos_html .= '
                                        <div class="d-flex">
                                            <div class="avatar avatar-online">
                                                <span class="avatar-title rounded-circle border border-white bg-success">C</span>
                                            </div>
                                            <div class="flex-1 ms-3 pt-1">
                                                <h6 class="text-uppercase fw-bold mb-1">Nuevo Paquete<span class="text-success ps-3">Compra</span></h6>
                                                <span class="text-muted">' . $fecha . '</span>
                                            </div>
                                            <div class="float-end pt-1">
                                                <small class="text-success">+' . intval($row['creditos']) . '</small>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>';
                                }
                               
                                $movimientos_html .= '</div>
                                                    </div>
                                                </div>';
                                                
                                $valemail = "";
                                $valnum = "";
                            } else{
                                $idUsr = "";
                                $nombre = "";
                                $apellido = "";
                                $tipus = '<option value="1" checked">Cliente</option>';
                                $mail = "";
                                $numero = "";
                                $pass = "";
                                $fecha_nacimiento = "";
                                $credit = "0";
                                $paquete = "";
                                $btnPaq = "";
                                $comprasHTML = "";
                                $elmusr = "";
                                $movimientos_html = "";
                                $valemail = 'onblur="validarCorreo()"';
                                $valnum = 'onblur="validarNumero()"';
                                $profilePath = "../assets/images/profiles/unknow.png";
                            }
                          
                            ?>
								<div class="card-body">
                                    <form action="save_user.php" method="post"  onsubmit="trimTrailingSpaces()">
                                    <div class="row">
                                       <div class="col-md-12" style="display: flex; align-items: center;justify-content: center; margin-block: 20px">
                                        <div class="avatar avatar-xxl">
                                            <img src="<?php echo $profilePath; ?>" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                       </div>
                                    </div>
                                    <input type="hidden" name="idu" id="idu" value="<?php echo $idUsr; ?>">
									<div class="row">
                                       <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3"> 
                                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre;?>" placeholder="name@example.com" required="">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido;?>" placeholder="name@example.com">
                                                <label for="apellido">Apellido</label>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                                <label for="tipouser">Tipo de Usuario</label>
                                                <select class="form-select" id="tipouser" name="tipouser">
                                                    <?php echo $tipus; ?>
                                                    <option value="1">Cliente</option>
                                                    <option value="2">Coach</option>
                                                    <option value="3">Administrador</option>
                                                    <option value="4">Recepción</option>
                                                </select>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="email" class="form-control" id="mail" name="mail" value="<?php echo $mail;?>" placeholder="name@example.com" required="" <?php echo $valemail; ?>>
                                                <label for="mail">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $numero;?>" placeholder="name@example.com" maxlength="10" minlength="9" required=""  <?php echo $valnum; ?>>
                                                <label for="numero">Número</label>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="pass" name="pass" value="<?php echo $pass;?>" placeholder="name@example.com" maxlength="10" minlength="9" required="">
                                                <label for="pass">Contraseña</label>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha_nacimiento;?>" placeholder="name@example.com">
                                                <label for="fecha">Fecha de Nacimiento</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="creditos" name="creditos" value="<?php echo $credit;?>" placeholder="name@example.com">
                                                <label for="creditos">Créditos</label>
                                            </div>
                                       </div>
                                       <div class="col-md-2">
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="date" class="form-control" id="vencecreditos" name="vencecreditos" value="<?php echo $credVenci;?>" placeholder="name@example.com">
                                                <label for="vencecreditos">Vencen el</label>
                                            </div>
                                       </div>
                                       <div class="col-md-3" >
                                          
                                            <div class="form-floating form-floating-custom mb-3">
                                                <?php echo $btnPaq; ?>
                                          
                                       </div>

                                    </div>
                                    <div style="display: flex; justify-content: center;margin-block: 20px;">
                                        <button class="btn btn-success" type="submit" id="btnsub">
                                            <span class="btn-label">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            Guardar
                                        </button>
                                        <?php
                                        echo $elmusr;
                                        ?>
                                    </div>
                                    </form>
                                    
								</div>
                               




							</div>
                            
						</div>

                                <div class="row">
                                    <?php echo $comprasHTML;
                                        echo $movimientos_html; ?>
                                    

                                </div>
                            <!--fin-->

						</div>
				
				</div>
			</div>
            <div id="overls" onclick="closeAp()" style="position: fixed; width: 100%; height: 100%; background-color: #00000078; z-index: 1001; top: 0; display: none"></div>
			<div class="card" id="asignarp" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1002; padding: 30px; min-width: 40%; display: none">
                <div class="card-header" style="display: flex;align-items: center;gap: 20px;">
                    <h4 class="card-title">Asignar Paquetes</h4>
                </div>
                <form action="asignar-paq.php" method="post">
                <div class="row" style="margin-block: 20px">
                    <div class="col-md-12">
                            <div class="card-title"><?php echo $nombre; ?></div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px">
                        <div class="form-group form-group-default">
                            <label>Paquete</label>
                            <select class="form-select" id="paquete" name="paquete">
                            <?php
                                include '../db.php'; 

                                $sql = "SELECT id, nombre, clases, costo FROM paquetes";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nombre']) . ' ( ' . htmlspecialchars($row['clases']) . ' Clases - $' . $row['costo'] . ')</option>';
                                    }
                                } else {
                                    echo '<option disabled>No hay paquetes disponibles</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="iden" id="iden" value="<?php echo $idUsr; ?>">
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Metodo de Pago</label>
                            <select class="form-select" id="metod" name="metod">
                                <option value="1">Efectivo</option>
                                <option value="2">Tarjeta</option>
                            </select>
                        </div>
                    
                    </div>        
                    <div class="col-md-12" style="justify-content: space-between;display: flex; margin-top: 30px">
                    <button class="btn btn-danger" type="button" onclick="closeAp()">Cancelar</button>
                        <button class="btn btn-success" type="submit">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Asignar
                        </button>
                    </div>
                </form>
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
       function validarCorreo() {
  const input = document.getElementById("mail");
  const correo = input.value.trim();
  input.value = correo; // actualiza el campo sin espacios

  if (correo === "") {
    input.style.border = "2px solid red";
    document.getElementById("btnsub").disabled = true;
    return;
  }

  fetch("validar_existencia.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `campo=mail&valor=${encodeURIComponent(correo)}`
  })
  .then(res => res.json())
  .then(data => {
    const btn = document.getElementById("btnsub");

    if (data.existe) {
      input.style.border = "2px solid red";
      btn.disabled = true;
    } else {
      input.style.border = "";
      validarEstadoBoton();
    }
  });
}

function validarNumero() {
  const input = document.getElementById("numero");
  const numero = input.value.trim();
  input.value = numero; // actualiza el campo sin espacios

  if (numero === "") {
    input.style.border = "2px solid red";
    document.getElementById("btnsub").disabled = true;
    return;
  }

  fetch("validar_existencia.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `campo=numero&valor=${encodeURIComponent(numero)}`
  })
  .then(res => res.json())
  .then(data => {
    const btn = document.getElementById("btnsub");

    if (data.existe) {
      input.style.border = "2px solid red";
      btn.disabled = true;
    } else {
      input.style.border = "";
      validarEstadoBoton();
    }
  });
}

function validarEstadoBoton() {
  const correo = document.getElementById("mail").style.border;
  const numero = document.getElementById("numero").style.border;
  const btn = document.getElementById("btnsub");

  if (correo.includes("red") || numero.includes("red")) {
    btn.disabled = true;
  } else {
    btn.disabled = false;
  }
}


        function eliminarUsuario(id) {
          swal({
            title: "¿Estás seguro?",
            text: "Una vez eliminado, no podrás recuperar este usuario.",
            icon: "warning",
            buttons: ["Cancelar", "Eliminar"],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              fetch('eliminar_usuario.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${encodeURIComponent(id)}`
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  swal("Usuario eliminado correctamente", {
                    icon: "success",
                  }).then(() => {
                    window.location.href = "clientes.php";
                  });
                } else {
                  swal("Error", data.message || "No se pudo eliminar el usuario.", "error");
                }
              })
              .catch(error => {
                console.error("Error en la solicitud:", error);
                swal("Error", "Ocurrió un error al eliminar el usuario.", "error");
              });
            }
          });
        }

        function openAp() {
            document.getElementById('asignarp').style.display = 'block';
            document.getElementById('overls').style.display = 'block';  
        }
        function closeAp() {
            document.getElementById('asignarp').style.display = 'none';
            document.getElementById('overls').style.display = 'none';   
        }
        function trimTrailingSpaces() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"]');

            inputs.forEach(input => {
                input.value = input.value.replace(/\s+$/, ''); 
            });
        }
</script>


</body>
</html>