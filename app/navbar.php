<div class="main-header">
				<div class="main-header-logo">
					<!-- Logo Header -->
					<div class="logo-header" data-background-color="">

						<a href="index.html" class="logo">
                        <img src="../assets/images/svg/logo-negro.svg"  height="106"
                        alt>
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
				<!-- Navbar Header -->
				<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

					<div class="container-fluid">
						

						<ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
							
							
							<li class="nav-item topbar-icon dropdown hidden-caret">
								<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-bell"></i>
									<span class="notification">4</span>
								</a>
								<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
									<li>
										<div class="dropdown-title">Notificaciones</div>
									</li>
									<li>
										<div class="notif-scroll scrollbar-outer">
											<div class="notif-center">
												<a href="#">
													<div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
													<div class="notif-content">
														<span class="block">
															New user registered
														</span>
														<span class="time">5 minutes ago</span> 
													</div>
												</a>
												
											</div>
										</div>
									</li>
									
								</ul>
							</li>
							
							
							<li class="nav-item topbar-user dropdown hidden-caret">
								<a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
									<div class="avatar-sm">
										<img src="assets/img/unknnow.png" alt="..." class="avatar-img rounded-circle">
									</div>
									<span class="profile-username">
										<span class="op-7">Hola,</span> <span class="fw-bold"><?php
																								$nombreCompleto = $_SESSION['nombre'];
																								$primerNombre = explode(' ', trim($nombreCompleto))[0];
																								echo $primerNombre;
																								?></span>
									</span>
								</a>
								<ul class="dropdown-menu dropdown-user animated fadeIn">
									<div class="dropdown-user-scroll scrollbar-outer">
										<li>
											<div class="user-box">
												<div class="avatar-lg"><img src="assets/img/unknnow.png" alt="image profile" class="avatar-img rounded"></div>
												<div class="u-text" >
													<h4><?php echo $_SESSION['nombre']; ?></h4>
													<p><?php echo $_SESSION['mail'];?></p>
												</div>
											</div>
										</li>
										<li>
											<a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
										</li>
									</div>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
				<!-- End Navbar -->
			</div>