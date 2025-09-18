<style>
	.ionicon {
		width: 1.3rem;
		margin-left: .2rem;
		fill: white;
	}

	a:hover>.ionicon {
		fill: #bbff00ff;
		color: #bbff00ff;
	}

	.color-icons-theme i {
		color: white !important;
	}

	.color-icons-theme p {
		color: white;
	}

	#nav-bar-decoration .nav-item:hover a,
	#nav-bar-decoration .nav-item:hover a i,
	#nav-bar-decoration .nav-item:hover a p {
		fill: #bbff00ff !important;
		color: #bbff00ff !important;
	}


	@media(min-width:992px) {
		.logo {
			background-image: url("../assets/images/ubarre/svg/ubarre-sin-tagline.svg");
			height: 186px;
			width: 150px;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}
	}

	@media (max-width: 991px) {

		.logo {
			background-image: url("../assets/images/ubarre/svg/ubarre-negro.svg");
			height: 186px;
			width: 150px;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}

	}
</style>

<div class="sidebar" id="nav-bar-decoration" data-background-color="" style="background-color: #8B976A;">
	<div class="sidebar-logo">
		<!-- Logo Header -->
		<div class="logo-header color-icons-theme" data-background-color="">

			<a href="index.php" class="logo">

			</a>
			<div class="nav-toggle">
				<button class="btn btn-toggle toggle-sidebar">
					<i class="gg-menu-right"></i>
				</button>
				<button class="btn btn-toggle sidenav-toggler">
					<i class="gg-menu-left"></i>
				</button>
			</div>
			<button class="topbar-toggler more">
				<i class="gg-more-vertical-alt"></i>
			</button>

		</div>
		<!-- End Logo Header -->
	</div>
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<ul class="nav color-icons-theme">
				<li class="nav-item">
					<a href="index.php" class="decoration-theme">
						<i class="fas fa-home"></i>
						<p>Inicio</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="registra-class.php" class="decoration-theme">
						<i class="fas fa-qrcode"></i>
						<p>Asistencia</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="clientes.php">
						<i class="fas fa-users"></i>
						<p>Usuarios</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="clases.php">
						<i class="fas fa-award"></i>
						<p>Clases</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="finanzas.php">
						<i class="fas fa-chart-bar"></i>
						<p>Finanzas</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="coach.php">
						<i class="fas fa-user-circle"></i>
						<p>Coaches</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="disciplinas.php">
						<i class="fas fa-graduation-cap"></i>
						<p>Disciplinas</p>
					</a>
				</li>

				
				<li class="nav-item">
					<a href="paquetes.php">
						<i class="fas fa-boxes"></i>
						<p>Paquetes</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="smoothies.php" style="gap: 1.3rem;">
						<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
							<title>Pint</title>
							<path d="M399 99.29L394 16H118.45L113 99.26c-1.29 19.24-2.23 33.14 3.73 65.66 1.67 9.11 5.22 
								22.66 9.73 39.82 12.61 48 33.71 128.36 33.71 195.63V496h191.68v-95.62c0-77.09 21.31-153.29 34-198.81 4.38-15.63 7.83-28 
								9.41-36.62 6.01-32.51 5.07-46.42 3.74-65.66zM146.23 80l2-32h215.52l2 32z" />
						</svg>
						<p>Smoothies</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="../profile.php">
						<i class="fas fa-power-off"></i>
						<p>Salir</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="soporte.php">
						<i class="fas fa-headset"></i>
						<p>Soporte</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>