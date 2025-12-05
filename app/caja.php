<?php
session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {
    header("Location: ../login.php");
    exit;
}

$tipoUser = (int)$_SESSION['tipoUser'];
// Solo recepción (4) y admin (3) pueden acceder
if ($tipoUser !== 3 && $tipoUser !== 4) {
    header("Location: ../profile.php");
    exit;
}

// TICKET 4: Ejecutar limpieza automática de descuentos expirados
define('AUTO_CLEAN_ALLOWED', true);
include_once '../auto-clean-discounts.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>übarre | Caja</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="shortcut icon" href="../assets/images/ubarre/favicon_ubarre.png" type="image/svg+xml">
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
	<link rel="stylesheet" href="./assets/css/demo.css">

	<style>
		.icon{
			fill: #fff;
			width: 60px;
		}
		.productos-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
			gap: 15px;
			margin-bottom: 30px;
		}
		.producto-card {
			background: white;
			border: 2px solid #ddd;
			border-radius: 12px;
			padding: 20px;
			text-align: center;
			cursor: pointer;
			transition: all 0.3s ease;
		}
		.producto-card:hover {
			border-color: #986C5D;
			box-shadow: 0 4px 12px rgba(152, 108, 93, 0.2);
			transform: translateY(-3px);
		}
		.producto-nombre {
			font-weight: 600;
			font-size: 1.1rem;
			margin: 10px 0;
			color: #333;
		}
		.producto-precio {
			color: #986C5D;
			font-size: 1.3rem;
			font-weight: bold;
		}
		.producto-tipo {
			display: inline-block;
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 0.75rem;
			margin-top: 5px;
			background-color: #986C5D;
			color: white;
			text-transform: uppercase;
		}
		.metodo-badge {
			padding: 4px 12px;
			border-radius: 12px;
			font-size: 0.85rem;
			color: white;
			font-weight: 500;
		}
		.metodo-efectivo {
			background: #28a745;
		}
		.metodo-tarjeta {
			background: #007bff;
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
							<h3 class="fw-bold mb-3">💰 Caja del Día</h3>
							<h6 class="op-7 mb-2">Registro de ventas - <?php echo date('d/m/Y'); ?></h6>
						</div>
					</div>

					<!-- Estadísticas del día -->
					<div class="row row-card-no-pd">
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-money-bill-wave text-success"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Total Efectivo</p>
												<h4 class="card-title" id="total-efectivo">$0.00</h4>
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
												<i class="fas fa-credit-card text-primary"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Total Tarjeta</p>
												<h4 class="card-title" id="total-tarjeta">$0.00</h4>
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
												<i class="fas fa-dollar-sign text-warning"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Total del Día</p>
												<h4 class="card-title" id="total-general">$0.00</h4>
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
												<i class="fas fa-shopping-cart text-info"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Ventas</p>
												<h4 class="card-title" id="total-ventas">0</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Productos disponibles -->
					<div class="row mt-4">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Registrar Venta</h4>
								</div>
								<div class="card-body">
									<div id="productos-container" class="productos-grid">
										<div style="grid-column: 1/-1; text-align: center; padding: 20px;">
											Cargando productos...
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Historial de ventas del día -->
					<div class="row mt-4">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center justify-content-between">
										<h4 class="card-title">Ventas del Día</h4>
										<button class="btn btn-primary btn-round" onclick="generarCorte()">
											<i class="fas fa-file-pdf"></i> Generar Corte de Caja
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover">
											<thead>
												<tr>
													<th>Hora</th>
													<th>Producto</th>
													<th>Cantidad</th>
													<th>Precio Unit.</th>
													<th>Total</th>
													<th>Método</th>
													<th>Vendedor</th>
													<?php if($tipoUser === 3) { echo '<th>Acciones</th>'; } ?>
												</tr>
											</thead>
											<tbody id="ventas-tabla">
												<tr>
													<td colspan="<?php echo $tipoUser === 3 ? '8' : '7'; ?>" class="text-center">
														No hay ventas registradas
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<footer class="footer">
				<div class="container-fluid d-flex justify-content-between">
					<div class="copyright">
						2024, Ü Barre <i class="fa fa-heart heart text-danger"></i>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<!--   Core JS Files   -->
	<script src="./assets/js/core/jquery-3.7.1.min.js"></script>
	<script src="./assets/js/core/popper.min.js"></script>
	<script src="./assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

	<!-- Kaiadmin JS -->
	<script src="./assets/js/kaiadmin.min.js"></script>

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		let productosData = [];

		// Cargar datos al iniciar
		document.addEventListener('DOMContentLoaded', function() {
			cargarProductos();
			cargarVentasDelDia();
			// Actualizar cada 30 segundos
			setInterval(cargarVentasDelDia, 30000);
		});

		function cargarProductos() {
			fetch('get-productos.php')
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						productosData = data.productos;
						mostrarProductos(data.productos);
					}
				})
				.catch(error => console.error('Error:', error));
		}

		function mostrarProductos(productos) {
			const container = document.getElementById('productos-container');
			if (productos.length === 0) {
				container.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 20px; color: #999;">No hay productos disponibles</div>';
				return;
			}

			container.innerHTML = productos.map(p => `
				<div class="producto-card" onclick="venderProducto(${p.id})">
					<div class="producto-nombre">${p.nombre}</div>
					<div class="producto-precio">$${parseFloat(p.costo).toFixed(2)}</div>
					<span class="producto-tipo">${p.tipo}</span>
				</div>
			`).join('');
		}

		function venderProducto(idProducto) {
			const producto = productosData.find(p => p.id == idProducto);
			if (!producto) return;

			Swal.fire({
				title: producto.nombre,
				text: `¿Registrar venta por $${parseFloat(producto.costo).toFixed(2)}?`,
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: '💵 Efectivo',
				cancelButtonText: '💳 Tarjeta',
				showDenyButton: true,
				denyButtonText: 'Cancelar',
				confirmButtonColor: '#28a745',
				cancelButtonColor: '#007bff',
				denyButtonColor: '#6c757d'
			}).then((result) => {
				if (result.isConfirmed) {
					registrarVenta(idProducto, 1, 'efectivo');
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					registrarVenta(idProducto, 1, 'tarjeta');
				}
			});
		}

		function registrarVenta(idProducto, cantidad, metodoPago) {
			fetch('procesar-venta.php', {
				method: 'POST',
				headers: {'Content-Type': 'application/json'},
				body: JSON.stringify({
					id_producto: idProducto,
					cantidad: cantidad,
					metodo_pago: metodoPago
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					Swal.fire({
						icon: 'success',
						title: 'Venta Registrada',
						text: `Total: $${parseFloat(data.total).toFixed(2)}`,
						timer: 2000,
						showConfirmButton: false
					});
					cargarVentasDelDia();
				} else {
					Swal.fire('Error', data.message || 'No se pudo registrar', 'error');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				Swal.fire('Error', 'Error de conexión', 'error');
			});
		}

		function cargarVentasDelDia() {
			fetch('get-ventas-dia.php')
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						mostrarVentas(data.ventas, data.total, data.por_metodo);
					}
				})
				.catch(error => console.error('Error:', error));
		}

		function mostrarVentas(ventas, total, porMetodo) {
			const tbody = document.getElementById('ventas-tabla');
			const tipoUser = <?php echo $tipoUser; ?>;

			if (ventas.length === 0) {
				tbody.innerHTML = `<tr><td colspan="${tipoUser === 3 ? '8' : '7'}" class="text-center">No hay ventas registradas</td></tr>`;
			} else {
				tbody.innerHTML = ventas.map(v => `
					<tr>
						<td>${v.hora}</td>
						<td>${v.nombre_producto}</td>
						<td>${v.cantidad}</td>
						<td>$${parseFloat(v.precio_unitario).toFixed(2)}</td>
						<td><strong>$${parseFloat(v.total).toFixed(2)}</strong></td>
						<td><span class="metodo-badge metodo-${v.metodo_pago}">${v.metodo_pago === 'efectivo' ? '💵 Efectivo' : '💳 Tarjeta'}</span></td>
						<td>${v.vendedor_nombre}</td>
						${tipoUser === 3 ? `<td><button class="btn btn-danger btn-sm" onclick="eliminarVenta(${v.id})"><i class="fas fa-trash"></i></button></td>` : ''}
					</tr>
				`).join('');
			}

			// Actualizar estadísticas
			document.getElementById('total-efectivo').textContent = '$' + parseFloat(porMetodo.efectivo || 0).toFixed(2);
			document.getElementById('total-tarjeta').textContent = '$' + parseFloat(porMetodo.tarjeta || 0).toFixed(2);
			document.getElementById('total-general').textContent = '$' + parseFloat(total).toFixed(2);
			document.getElementById('total-ventas').textContent = ventas.length;
		}

		function eliminarVenta(idVenta) {
			Swal.fire({
				title: '¿Eliminar venta?',
				text: 'Esta acción no se puede deshacer',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Sí, eliminar',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#dc3545'
			}).then((result) => {
				if (result.isConfirmed) {
					fetch('eliminar-venta.php', {
						method: 'POST',
						headers: {'Content-Type': 'application/json'},
						body: JSON.stringify({id: idVenta})
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							Swal.fire('Eliminado', 'Venta eliminada correctamente', 'success');
							cargarVentasDelDia();
						} else {
							Swal.fire('Error', data.message, 'error');
						}
					});
				}
			});
		}

		function generarCorte() {
			window.open('corte-caja.php?fecha=' + new Date().toISOString().split('T')[0], '_blank');
		}
	</script>
</body>
</html>
