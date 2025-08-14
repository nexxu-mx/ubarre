<?php
session_start();
include 'db.php';

if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$idUser = $_SESSION['idUser'];
$profileFilename = $idUser . ".png";
$realProfilePath = "./assets/images/profiles/" . $profileFilename;

if (file_exists($realProfilePath)) {
    $profilePath = $realProfilePath . "?v=$timest";
} else {
    $profilePath = "./assets/images/profiles/unknow.png?v=$timest";
}

if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

?>
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
    <?php include 'head.php'; ?>
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <!-- FullCalendar Locale (español) -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <link rel="stylesheet" href="./assets/css/profile.css?v=<?php echo time(); ?>"> 
    <style>
       
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
    .al1{
        width: 100%;
        height: 40vh;
        overflow: auto;
    }
    .al2{
        padding: 5px;
        border-bottom: 1px solid #d6d6d6;
    }
    </style>
</head>

<body id="top">
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php //include 'ofer.php'; ?> 
    <?php include 'header.php'; ?>

    
    <div style="position: fixed; z-index: -1; top: 0; left: 0; width: 100%; height: 100%">
        <video style="height: 200%;" src="./assets/images/sencia_gradient.mp4" autoplay loop muted></video>
    </div>
    <!-- MAIN SECTION -->
    <main>
        <article>
            <section class="secti-on">
                
                <!-- INICIO -->
                <div class="container p1" id="profile-inicio">
                    <div class="p6">
                        <div class="p7">
                            <img src="<?php echo $profilePath ?>" class="p8" alt="">
                        </div>
                        <div class="p9">
                            <span id="name"></span>
                            <h4 class="p10" id="credits">
                           
                            </h4>

                           
                            <p class="p10" id="vence" style="font-size: 1.3rem">
                           
                            </p>
                            

                            
                        </div>
                        <div class="p5">
                            <button class="p3" onclick="openCalendar()"><ion-icon name="checkbox-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Mis Reservas</p></button>
                            <?php 
                            if($_SESSION['tipoUser'] == 2){
                                echo '<button class="p3" onclick="coachCalendar()"><ion-icon name="calendar-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Mis Clases</p></button>';
                            }
                            ?>
                            <button class="p3" onclick="openClases()"><ion-icon name="calendar-number-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Clases</p></button>
                            <button class="p3" onclick="openPerfil()"><ion-icon name="person-circle-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Perfil</p></button>
                            <button class="p3" onclick="openPayment()"><ion-icon name="card-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Medios de Pago</p></button>
                            <button class="p3" onclick="openPaquetes()"><ion-icon name="bag-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Paquetes</p></button>
                            <!-- <button class="p3"><ion-icon name="library-outline" aria-hidden="true" class="p2" style="background: #c5c5c5;"></ion-icon> <p class="p4">Comunidad</p></button>-->
                            <button class="p3" onclick="closeSession()"><ion-icon name="power" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Cerrar Sesión</p></button>
                            <?php 
                            if($_SESSION['tipoUser'] == 3){
                                echo '<button class="p3" onclick="openAdmin()"><ion-icon name="newspaper-outline" aria-hidden="true" class="p2"></ion-icon> <p class="p4">Administración</p></button>';
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
                    <!-- CALENDARIO --> 
                <div class="container p1" id="profile-calendario" style="display: none">
                    <div class="head-profile" style="display: flex; align-items: center; gap: 10px; font-size: 3rem">
                        <button onclick="openInicio()"> <ion-icon name="arrow-back-outline" aria-hidden="true"></ion-icon></button>
                        <div class="" id="calendarProfile" >
                        <div class="first-flex" style="margin-top: 0">
                            <h2>Calendario de Clases</h2>  
                        </div>        
                    </div>
                    </div>
                     <div id="calendar"></div>
                </div>

                

                    <!-- Perfil -->
                <div class="container p1" id="profile-perfil" style="display: none">
                    <div class="head-profile" style="display: flex; align-items: center; gap: 10px; font-size: 3rem">
                        <button onclick="openInicio()"> <ion-icon name="arrow-back-outline" aria-hidden="true"></ion-icon></button>
                        <div class="" id="calendarProfile" >
                            <div class="first-flex" style="margin-top: 0">
                                <h2>Perfil</h2>  
                            </div>        
                        </div>
                    </div> 
                    <div class="p12">
                                
                        <div id="datosUser" class="p13">
                                <div class="p7" style="position: relative">
                                    <img src="<?php echo $profilePath ?>" class="p8" alt="">
                                    <div class="p15" onclick="selectImage()">
                                    <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                                        <ion-icon name="pencil-outline" aria-hidden="true"></ion-icon>
                                    </div>
                                </div>
                            <input type="text" name="nombre" id="nombre" maxlength="100" minlength="5">
                            <div class="p14"></div>
                            <input type="email" name="mail" id="mail" maxlength="100" minlength="5">
                            <div class="p14"></div>
                            <input type="text" name="numero" id="numero" maxlength="10" minlength="9">
                            <div class="p14"></div>
                            <label for="date">Fecha de Nacimiento</label>
                            <div class="inputs-reserva-container">
                                <select name="dia" id="dia"></select>
                                <select name="mes" id="mes"></select>
                                <select name="anio" id="anio"></select>
                                
                            </div>
                            <button type="button" id="guardarBtn" class="ver-mas-paquetes-btn">Guardar</button>
                        </div>
                    </div>
    
                </div>

                   <!-- Medios de Pago -->
                   <div class="container p1" id="profile-medios" style="display: none">
                    <div class="head-profile" style="display: flex; align-items: center; gap: 10px; font-size: 3rem">
                        <button onclick="openInicio()"> <ion-icon name="arrow-back-outline" aria-hidden="true"></ion-icon></button>
                        <div class="" id="calendarProfile" >
                            <div class="first-flex" style="margin-top: 0">
                                <h2>Mis Tarjetas</h2>  
                            </div>        
                        </div>
                    </div> 
                    <div class="p11" id="myCards"></div>      
                </div>



                    <!-- Reserva -->
                    <div class="container p1" id="profile-" style="display: none">
                    <div class="head-profile" style="display: flex; align-items: center; gap: 10px; font-size: 3rem">
                        <button onclick="openInicio()"> <ion-icon name="arrow-back-outline" aria-hidden="true"></ion-icon></button>
                        <div class="" id="calendarProfile" >
                            <div class="first-flex" style="margin-top: 0">
                                <h2>Perfil</h2>  
                            </div>        
                        </div>
                    </div>       
                </div>


            </section>
            
        </article>
    </main>

    <!-- Modal personalizado -->
    <div id="eventoModal" class="modalCal">
        <div class="modal-contentCal" id="modal-content">
            <div class="m1">
                <h2>Clase Reservada</h2>
                <span class="closeCal" id="cerrarModal">X</span>
            </div>
            <div class="m2">
                <div class="m3">
                    <p class="m4"><ion-icon name="person-circle-outline" aria-hidden="true"></ion-icon> <a href="#" id="modalInstructor"></a></p>
                    <span id="modalTitulo" class="m5"></span>
                    <h4 class="m6"><ion-icon name="time-outline" aria-hidden="true"></ion-icon> <p id="modalDuracion"></p></h4>
                    <div class="m7">
                            <div class="m8">
                                <small style="display: flex; align-items: first baseline; gap: 2px" id="modalInvitado"><ion-icon name="person" aria-hidden="true"></ion-icon> x1</small><br>
                                <small>Inicio</small>
                                <p id="modalInicio"></p>
                            </div>
                            <div class="iconos-container">
                                <div class="aforo-container">
                                    <img src="assets/images/svg/people-sharp.svg" alt="Aforo Ícono">
                                    <p id="aforo"></p>
                                </div>
                                <div class="status-clase-icono" id="clastatus">
                                   
                                </div>
                            </div>
                    </div>
                </div>
                <div class="qr-code" id="qrcode"></div>
                <div class="m9" >
                    <div id=invitarModal></div>
                    <div  id="buttonModal"></div>
                   
                </div>
            </div>
        </div>
    </div>


   
   
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script src="./assets/js/profile.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>