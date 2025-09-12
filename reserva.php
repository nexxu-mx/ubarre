<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>übarre | Reserva</title>
    <meta name="title" content="übarre">
    <meta name="description" content="ÜBARRE es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral.">
    <link rel="shortcut icon" href="./assets/images/ubarre/favicon_ubarre.png" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/estilos_ubarre.css?v=<?php echo time(); ?>">
    <?php include 'head.php'; ?>

    <!-- <style>
    .smoothies-disponibles {
      text-align: center;
      margin: 10px 0;
      font-size: 12px;
      color: #888;
    }
    
    .smoothies-disponibles p {
      margin: 0;
      font-style: italic;
      line-height: 1.3;
    }
    </style> -->

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
            <section class="reserva-main-section">

                <div class="container">
                    <div class="aboutus-top">
                        <div class="aboutus-elemento-izquierda">
                            <img src="./assets/images/ubarre/svg/dots.svg" alt="">
                        </div>
                        <div class="aboutus-elemento-derecha">
                            <img src="./assets/images/ubarre/svg/icon.svg" alt="">
                        </div>
                    </div>

                    <h1 style="color: #56514F; margin-top: 60px">Reserva tu clase</h1>


                    <!-- Contenededor para Agregar Smoothie -->
                    <div class="modal-detalles-bebida">
                        <div class="modal-content">
                            <div class="container-slider-bebidas">
                                <div class="flecha-slider-izquierda">
                                    <button>
                                        <img src="./assets/images/svg/flecha-blanca.svg" alt="">
                                    </button>
                                </div>
                                <div class="flecha-slider-derecha">
                                    <button>
                                        <img src="./assets/images/svg/flecha-blanca.svg" alt="">
                                    </button>
                                </div>

                                <div class="slides-wrapper" id="smoothie-slides">
                                </div>

                                <!-- Se carga en script.js  en cargarSmoothies -->

                            </div>
                        </div>
                    </div>
                    <!--  Hasta aqui -->

                    <!-- Contenedor de resumen y confirmación de reserva -->
                    <div class="confirmation-section" id="confirm-class">
                        <h2>Confirmación de Reserva</h2>
                        <div class="fecha-clase-container">
                            <p><span id="texto-dia-din-conf" class="texto-fecha-din">Hoy</span>, <span id="mes-din-conf" class="texto-fecha-din">Marzo</span> <span id="numero-dia-din-conf" class="texto-fecha-din">27</span></p>
                        </div>
                        <div class="clase-container elemento-clase-confirmacion">
                            <div class="first-flex-clase">
                                <div class="img-clase-container">
                                    <img src="assets/images/coaches/unknnow.png" alt="Foto Coach" id="confirm-coach-img">
                                </div>
                                <div class="nombrecoach-horarioclase version-confirmacion">
                                    <div class="nombre-coach">
                                        <p id="confirm-coach"></p>
                                    </div>
                                    <div class="horario-clase">
                                        <h3 id="confirm-horario"></h3>
                                        <h4 id="confirm-duracion"></h4>
                                    </div>
                                    <div class="nombre-bebida">
                                        <p>Bebida:</p>
                                        <h3 id="confirm-bebida"></h3>
                                        <h4 id="confirm-momento"></h4>
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
                    <div class="contenido-seleccion-clase">
                        <div class="encuentra-container">
                            <p class="my-account-link"><a href="login.php" id="my-account">MY ACCOUNT</a></p>
                            <div class="first-flex">
                                <div class="hint-flex">
                                    <h2>Encuentra tu clase</h2>
                                    <svg id="hint-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <title>Help Circle</title>
                                        <path d="M256 64C150 64 64 150 64 256s86 192 192 192 192-86 192-192S362 64 256 64zm-6 304a20 20 0 1120-20 20 20 0 01-20 20zm33.44-102C267.23 276.88 265 286.85 265 296a14 14 0 01-28 0c0-21.91 10.08-39.33 30.82-53.26C287.1 229.8 298 221.6 298 203.57c0-12.26-7-21.57-21.49-28.46-3.41-1.62-11-3.2-20.34-3.09-11.72.15-20.82 2.95-27.83 8.59C215.12 191.25 214 202.83 214 203a14 14 0 11-28-1.35c.11-2.43 1.8-24.32 24.77-42.8 11.91-9.58 27.06-14.56 45-14.78 12.7-.15 24.63 2 32.72 5.82C312.7 161.34 326 180.43 326 203.57c0 33.83-22.61 49.02-42.56 62.43z" />
                                    </svg>
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
                                    <svg class="icono-clase-en-curso" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.35 311.78">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: #8B976A;
                                                }
                                            </style>
                                        </defs>
                                        <g id="Capa_2" data-name="Capa 2">
                                            <g id="Capa_1-2" data-name="Capa 1">
                                                <path class="cls-1" d="M95.34,0c20.12,0,35.81,16.09,35.81,34.2S119.08,64.78,103,64.78c-19.72,0-35.41-15.69-35.41-34.6C67.58,12.07,79.65,0,95.34,0" />
                                                <path class="cls-1" d="M21.88,95C7,99.84-3.27,112.79,1,130.26c2.61,10.79,9.24,20.43,27.62,26.75,6,2.05,8.77,2.77,15.92,5,33.8,10.57,76.18,23.15,101.93,38.31,32.41,19.11,39.27,35.47,34.28,46.83a.07.07,0,0,1,0,0c-5.74,9-15.28,6.47-24.7,2.91-8.26-3.86-78.44-36-101.92-33.35C32.75,219.16,23.82,232.7,26,253.25A50.23,50.23,0,0,0,41,282l.19.18C55.16,296.64,75.45,310,75.45,310a16.4,16.4,0,0,0,21-5.46l.08-.11a17,17,0,0,0,2.73-12.18,16.81,16.81,0,0,0-5.68-10.11L62.89,258.29a3.81,3.81,0,0,1-1.74-2.91l0-.16a3.66,3.66,0,0,1,3-4.05c5.88-1.15,45.56,16,82.21,33.17a97.9,97.9,0,0,0,13.43,5.16c4.71,1.41,16.06,3.59,27.26-.81,13.5-5.3,20-17.58,20.29-18.05,5.37-8.86,7.16-21,5.35-36,0,0-2.32-32.22-26.75-52.64a147.28,147.28,0,0,0-31.49-19.62c-13.58-6.43-59.28-20.23-78.33-25.87-5-1.23-18.74-5.79-19.22-6.1a1.25,1.25,0,0,1-.4-1.85c.22-.26.78-.4,1.75-.35l11.17.74s0,0,0,0l117.11,3.72a2.22,2.22,0,0,0,1.7-.83,2,2,0,0,0,.41-1.66l-7-35.47a2.08,2.08,0,0,0-2.1-1.65c-5.17,0-124.19.08-142.47.09A56.91,56.91,0,0,0,21.88,95" />
                                            </g>
                                        </g>
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
                                <br>MINDFUL MOVEMENT
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <section class="modal-detalles-coach">
        <div class="contenido-modal-coach-container">
            <img class="foto-coach-details-modal" src="" id="coach-info-img" alt="Foto Coach">
            <div class="contenido-texto-modal">
                <h3 class="nombre-coach-details-modal" id="coach-info-nombre"></h3>
                <p class="texto-coach-details-modal" id="coach-info-descripcion"></p>
                <a href="#">Reserva con nuestra coach</a>
            </div>
        </div>
    </section>

    <!-- Contenededor para Agregar Smoothie -->

    <div class="modal-detalles-bebida">
        <div class="modal-content">
            <div class="container-slider-bebidas">
                <div class="flecha-slider-izquierda">
                    <button>
                        <img src="./assets/images/svg/flecha-blanca.svg" alt="">
                    </button>
                </div>
                <div class="flecha-slider-derecha">
                    <button>
                        <img src="./assets/images/svg/flecha-blanca.svg" alt="">
                    </button>
                </div>

                <div class="slides-wrapper" id="smoothie-slides">
                </div>

                <!-- <div class="slide-bebida" data-bebida="Proteina Cacao">
                            <div>
                                <img src="./assets/images/aboutus.png" alt="">
                            </div>
                            <div>
                                <h3>Agregar Smoothie</h3>
                                <p>Proteina Cacao</p>
                                <div class="dropdown">
                                    <div class="dropdown-toggle">Al final de la clase</div>
                                    <ul class="dropdown-menu menu-bebidas">
                                        <li>Al final de la clase</li>
                                        <li>Al inicio de la clase</li>
                                        <li>Sin smoothie</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="botones-bebida">
                                <button class="close-bebida-modal-btn">CANCELAR</button>
                                <div class="btn-confirmar-bebida">
                                    <a href="#reserv" onclick="reservaClase(this)">AGREGAR</a>
                                </div>
                            </div>
                        </div>

                        <div class="slide-bebida" data-bebida="Proteina Vainilla">
                            <div>
                                <img src="./assets/images/aboutus.png" alt="">
                            </div>
                            <div>
                                <h3>Agregar Smoothie</h3>
                                <p>Proteina Vainilla</p>
                                <div class="dropdown">
                                    <div class="dropdown-toggle">Al final de la clase</div>
                                    <ul class="dropdown-menu menu-bebidas">
                                        <li>Al final de la clase</li>
                                        <li>Al inicio de la clase</li>
                                        <li>Sin smoothie</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="botones-bebida">
                                <button class="close-bebida-modal-btn">CANCELAR</button>
                                <div class="btn-confirmar-bebida">
                                    <a href="#reserv" onclick="reservaClase(this)">AGREGAR</a>
                                </div>
                            </div>
                        </div>

                        <div class="slide-bebida" data-bebida="Proteina Fresa">
                            <div>
                                <img src="./assets/images/aboutus.png" alt="">
                            </div>
                            <div>
                                <h3>Agregar Smoothie</h3>
                                <p>Proteina Fresa</p>
                                <div class="dropdown">
                                    <div class="dropdown-toggle">Al final de la clase</div>
                                    <ul class="dropdown-menu menu-bebidas">
                                        <li>Al final de la clase</li>
                                        <li>Al inicio de la clase</li>
                                        <li>Sin smoothie</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="botones-bebida">
                                <button class="close-bebida-modal-btn">CANCELAR</button>
                                <div class="btn-confirmar-bebida">
                                    <a href="#reserv" onclick="reservaClase(this)">AGREGAR</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

            </div>
        </div>
    </div>

    <!--  Hasta aqui -->

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
                <svg class="icono-clase-en-curso" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.35 311.78">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #8B976A;
                            }
                        </style>
                    </defs>
                    <g id="Capa_2" data-name="Capa 2">
                        <g id="Capa_1-2" data-name="Capa 1">
                            <path class="cls-1" d="M95.34,0c20.12,0,35.81,16.09,35.81,34.2S119.08,64.78,103,64.78c-19.72,0-35.41-15.69-35.41-34.6C67.58,12.07,79.65,0,95.34,0" />
                            <path class="cls-1" d="M21.88,95C7,99.84-3.27,112.79,1,130.26c2.61,10.79,9.24,20.43,27.62,26.75,6,2.05,8.77,2.77,15.92,5,33.8,10.57,76.18,23.15,101.93,38.31,32.41,19.11,39.27,35.47,34.28,46.83a.07.07,0,0,1,0,0c-5.74,9-15.28,6.47-24.7,2.91-8.26-3.86-78.44-36-101.92-33.35C32.75,219.16,23.82,232.7,26,253.25A50.23,50.23,0,0,0,41,282l.19.18C55.16,296.64,75.45,310,75.45,310a16.4,16.4,0,0,0,21-5.46l.08-.11a17,17,0,0,0,2.73-12.18,16.81,16.81,0,0,0-5.68-10.11L62.89,258.29a3.81,3.81,0,0,1-1.74-2.91l0-.16a3.66,3.66,0,0,1,3-4.05c5.88-1.15,45.56,16,82.21,33.17a97.9,97.9,0,0,0,13.43,5.16c4.71,1.41,16.06,3.59,27.26-.81,13.5-5.3,20-17.58,20.29-18.05,5.37-8.86,7.16-21,5.35-36,0,0-2.32-32.22-26.75-52.64a147.28,147.28,0,0,0-31.49-19.62c-13.58-6.43-59.28-20.23-78.33-25.87-5-1.23-18.74-5.79-19.22-6.1a1.25,1.25,0,0,1-.4-1.85c.22-.26.78-.4,1.75-.35l11.17.74s0,0,0,0l117.11,3.72a2.22,2.22,0,0,0,1.7-.83,2,2,0,0,0,.41-1.66l-7-35.47a2.08,2.08,0,0,0-2.1-1.65c-5.17,0-124.19.08-142.47.09A56.91,56.91,0,0,0,21.88,95" />
                        </g>
                    </g>
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
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php include 'script.php'; ?>

    <script>
        document.querySelectorAll('.modal-detalles-bebida .dropdown').forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu');

            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            });

            menu.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', () => {
                    toggle.textContent = item.textContent;
                    dropdown.classList.remove('open');

                    const modal = dropdown.closest('.modal-detalles-bebida');
                    const btnAgregar = modal.querySelector('.btn-confirmar-bebida a');

                    btnAgregar.dataset.momento = item.textContent.trim();

                    if (item.textContent.trim() === "Sin smoothie") {
                        btnAgregar.textContent = "CONFIRMAR";
                    } else {
                        btnAgregar.textContent = "AGREGAR";
                    }
                });
            });
        });


        document.addEventListener('click', (e) => {
            document.querySelectorAll('.modal-detalles-bebida .dropdown').forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        function setBebidaSeleccionada(nombreBebida) {
            const modal = document.querySelector(".modal-detalles-bebida");
            const btnAgregar = modal.querySelector(".btn-confirmar-bebida a");
            btnAgregar.dataset.bebida = nombreBebida;
        }
    </script>
</body>



</html>