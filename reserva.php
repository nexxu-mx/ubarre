<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sencia Studio</title>
    <meta name="title" content="Sencia Studio">
    <meta name="description" content="SENCIA es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral.">
    <link rel="shortcut icon" href="./favicon.png" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/estilos_ubarre.css?v=<?php echo time(); ?>">
    <?php include 'head.php'; ?>

</head>

<body id="top">
    <div class="bg-opacity-modals"></div>
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php include 'ofer.php'; ?>
    <?php include 'header.php'; ?>


    <main>
        <article>
            <section class="reserva-main-section" id="reserv" style="background: var(--danyfer-karina-color);">
          
                <div class="container">
            <!--        <img src="assets/images/svg/logo-blanco.svg" alt="Logo Sencia"> 
            -->
                <div class="aboutus-top">
                        <div class="aboutus-elemento-izquierda">
                            <button>
                                <ion-icon name="menu-outline" style="color: #1d1d1dff;"></ion-icon>
                            </button>
                        </div>
                        <div class="aboutus-elemento-derecha">
                            <img src="./assets/images/svg/bolsa.svg" alt="">
                        </div>
                </div>

                    <h1 style="color: var(--light-brown); margin-top: 60px">Reserva tu clase</h1>
                    
                    <div class="confirmation-section"  id="confirm-class">
                        <h2>Confirmación de Reserva</h2>
                        <div class="fecha-clase-container elemento-clase">
                            <p><span id="texto-dia-din-conf" class="texto-fecha-din">Hoy</span>, <span id="mes-din-conf" class="texto-fecha-din">Marzo</span> <span id="numero-dia-din-conf" class="texto-fecha-din">27</span></p>
                        </div>
                        <div class="clase-container elemento-clase">
                            <div class="first-flex-clase">
                                <div class="img-clase-container">
                                    <img src="assets/images/coaches/unknnow.png" alt="Foto Coach" id="confirm-coach-img">
                                </div>
                                <div class="nombrecoach-horarioclase">
                                    <div class="nombre-coach">
                                        <p id="confirm-coach"></p>
                                    </div>
                                    <div class="horario-clase">
                                        <h3 id="confirm-horario"></h3>
                                        <h4 id="confirm-duracion"></h4>
                                    </div>
                                    <div class="disciplina-clase-container">
                                        <p>Disciplina:</p>
                                        <h3 id="confirm-disciplina"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="confirmation-btns">
                            <p class="cancelar-confirmacion-reserva-btn" onclick="cancelConfirmacion()">Cancelar</p>
                            <p class="confirmar-reserva-btn" id="confirm-agendar" onclick="confirmacion(this)">Confirmar Reserva</p>
                        </div>
                        <p class="nota-cancelar-clase"><span>Nota</span>: Puedes cancelar tu reservación, con hasta 6 horas de anticipación desde "Mis Reservas"</p>
                    </div>
                    
                    <!-- Inicio Cards -->
                    <div>
                        <div class="encuentra-container">
                            <p class="my-account-link"><a href="login.php" id="my-account">MY ACCOUNT</a></p>
                            <div class="first-flex">
                                <div class="hint-flex">
                                    <h2>Encuentra tu clase</h2>
                                    <svg id="hint-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Help Circle</title><path d="M256 64C150 64 64 150 64 256s86 192 192 192 192-86 192-192S362 64 256 64zm-6 304a20 20 0 1120-20 20 20 0 01-20 20zm33.44-102C267.23 276.88 265 286.85 265 296a14 14 0 01-28 0c0-21.91 10.08-39.33 30.82-53.26C287.1 229.8 298 221.6 298 203.57c0-12.26-7-21.57-21.49-28.46-3.41-1.62-11-3.2-20.34-3.09-11.72.15-20.82 2.95-27.83 8.59C215.12 191.25 214 202.83 214 203a14 14 0 11-28-1.35c.11-2.43 1.8-24.32 24.77-42.8 11.91-9.58 27.06-14.56 45-14.78 12.7-.15 24.63 2 32.72 5.82C312.7 161.34 326 180.43 326 203.57c0 33.83-22.61 49.02-42.56 62.43z"/></svg>
                                </div>
                            </div>
                            <div class="second-flex">
                                <div class="icono-texto-reserva">
                                    <img class="icono-reserva" src="assets/images/svg/reservado.svg"
                                        alt="Clase reservada ícono">
                                    <p>Clase reservada</p>
                                </div>
                                <div class="icono-texto-reserva">
                                    <img class="icono-reserva" src="assets/images/svg/full_class.svg"
                                        alt="Clase llena ícono">
                                    <p>Clase llena</p>
                                </div>
                                <div class="icono-texto-reserva">
                                    <img class="icono-reserva" src="assets/images/svg/waiting_list.svg"
                                        alt="Lista de Espera ícono">
                                    <p>Lista de Espera</p>
                                </div>
                                <div class="icono-texto-reserva">
                                    <img class="aforo-icono" src="assets/images/svg/people-sharp.svg" alt="Aforo ícono">
                                    <p>Aforo</p>
                                </div>
                                <div class="icono-texto-reserva">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                                        viewBox="0 0 512 512">
                                        <defs>
                                            <style>
                                                .ionicon {
                                                    fill: #986C5D;
                                                }
                                            </style>
                                        </defs>
                                        <title>Ellipse</title>
                                        <path
                                            d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                                    </svg>
                                    <p>Clase en curso</p>
                                </div>
                            </div>
                            <div class="inputs-reserva-container">
                                <select name="tipo_clase" id="tipo_clase_input">
                                    <option value="TIPO DE CLASE">TIPO DE CLASE</option>
                                </select>
                                <select name="instructor" id="instructor_input">
                                    <option value="INSTRUCTOR">INSTRUCTOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="encuentra-container-calendario">
                            <div class="slider-calendar-container">
                                <p class="flecha-slider-calendar">
                                    < </p>

                                        <div class="slider-items-container" id="slider-container">
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                            <div class="day-slider">
                                                <p class="text-day-slider"></p>
                                                <p class="calendar-slider-number"></p>
                                            </div>
                                        </div>

                                        <p class="flecha-slider-calendar">></p>
                            </div>
                        </div>
                        <div class="encuentra-container">
                            <div class="clases-section-container">
                                <div class="fecha-clase-container">
                                    <p><span id="texto-dia-din" class="texto-fecha-din">Hoy</span>, <span id="mes-din" class="texto-fecha-din">Marzo</span> <span id="numero-dia-din" class="texto-fecha-din">27</span></p>
                                </div>
                                <div id="clazx"></div>
                            </div>
                        </div>
                </div>

                <div class="aboutus-bottom">
                        <div class="elemento-bottom-fundadoras aboutus-elemento-izquierda">
                            <h4>Fundadoras</h4>
                        </div>
                         <div class="elemento-bottom-fundadoras elemento-reviving aboutus-elemento-derecha">
                            <p>REVIVING THE 
                            <br>MINDFUL MOVEMENT</p>
                        </div>
                </div>
                </div>
            </section>
        </article>
    </main>

    <section class="modal-detalles-coach">
        <div class="header-details-container">
            <h2>About</h2>
            <p class="close-coach-modal-btn">X</p>
        </div>
        <div class="contenido-modal-coach-container">
            <img class="foto-coach-details-modal" src="" id="coach-info-img" alt="Foto Coach">
            <h3 class="nombre-coach-details-modal" id="coach-info-nombre"></h3>
            <p class="texto-coach-details-modal" id="coach-info-descripcion"></p>
        </div>
    </section>

    <section class="modal-detalles-disciplina">
        <div class="header-details-container">
            <h2>About</h2>
            <p class="close-disciplina-modal-btn">X</p>
        </div>
        <div class="contenido-modal-disciplina-container">
            <h3 class="nombre-disciplina-details-modal" id="disciplina-info-nombre"></h3>
            <p class="texto-disciplina-details-modal" id="disciplina-info-descripcion"></p>
        </div>
    </section>

    <dialog close>
        <p id="close-dialog-btn">X</p>
        <div class="">
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/reservado.svg"
                    alt="Clase reservada ícono">
                <p>Clase reservada</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/full_class.svg"
                    alt="Clase llena ícono">
                <p>Clase llena</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/waiting_list.svg"
                    alt="Lista de  ícono">
                <p>Lista de Espera</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="aforo-icono" src="assets/images/svg/people-sharp.svg" alt="Aforo ícono">
                <p>Aforo</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #986C5D;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Clase en curso</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #00D52B;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Disponible</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #ACACAC;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Cerrada</p>
            </div>
        </div>
    </dialog>

    <?php include 'footer.php'; ?>
    <a href="https://wa.me/524792179429?text=Hola,%20Quiero%20m%C3%A1s%20informaci%C3%B3n%20de%20SENCIA." class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp">
    </a>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php include 'script.php'; ?>
</body>

</html>