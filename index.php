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
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <?php include 'head.php'; ?>
  <style>
    
    .vosj{
      width: 101%;
      height: auto; 
    }
    @media (min-width: 767px){
     .vosj{
      height: 101%;
      width: auto; 
    }
    }
  </style>
</head>

<body id="top">
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>

  <?php include 'ofer.php'; ?>

  <?php include 'header.php'; ?>

  <main style="overflow: hidden;">
    <article>
      <section class="hero-banner" style="position: relative">
      <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; display: flex; justify-content: center; align-items: center;">
          <video autoplay loop muted playsinline style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; object-fit: cover; transform: translate(-50%, -50%);z-index: 2"
          poster="./assets/images/hero.png">
            <source src="./assets/images/banner-hero3.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <div class="bg-b"></div>
        <div class="container">
          <div class="hero-banner-elements">
            <div class="img-banner-container">
              <img src="./assets/images/svg/logo-blanco.svg"
                alt="Sencia Logo">
            </div>
            <h1>
              MOVE YOUR BODY,
              <span class="hero-banner-text-alt">Change your mind</span>
            </h1>
            <a href="reserva.php" class="reservar-btn-banner">RESERVAR</a>
          </div>
        </div>
      </section>

        <section class="descripcion-section">
          <video id="video-index-texto" src="./assets/images/sencia_gradient.mp4" autoplay loop muted playsinline disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback"></video>
          <div class="container section">
            <img src="assets/images/svg/logo-blanco.svg" alt="logo sencia">
            <p>
            SENCIA es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral. Su nombre proviene de la palabra “sentir”, representando la experiencia auténtica y consciente que cada persona vivirá en el estudio, donde se fomenta la fuerza, la flexibilidad y la armonía. SENCIA es un refugio donde cada persona puede alcanzar su mejor versión, orientada por el amor, la dedicación y la conexión.
          </p>
          <p>BARRE | YOGA | SCULPT | BALLET | PILATES</p>
        </div>
      </section>

      <section class="desciplinas-section">
        <div class="nombres-disciplinas">
          <div class="nombres-disciplinas-container">
            <h2>NUESTRAS DISCIPLINAS</h2>
            <ul style="height: 50vh;">
              <li id="barre" onclick="cambiarTextoVideo(barreTab)">BARRE</li>
              <li id="sculpt"
                onclick="cambiarTextoVideo(sculptTab)">SCULPT</li>
              <li id="pilates" class="active-video"
                onclick="cambiarTextoVideo(pilatesTab)">PILATES</li>
              <li id="yoga" onclick="cambiarTextoVideo(yogaTab)">YOGA</li>
              <li id="ballet"
                onclick="cambiarTextoVideo(balletTab)">BALLET</li>
            </ul>
            <a href="clases.php">CONOCE NUESTRAS CLASES</a>
          </div>
        </div>
        <div class="video">
        <video autoplay loop muted playsinline class="vosj" id="videodisciplina">
              <source src="./assets/images/disciplinas/1.mp4?v=<?php echo time(); ?>" type="video/mp4">
              Your browser does not support the video tag.
          </video>
          <div class="text-video-container">
            <p id="texto-camb-1" class="texto-uppercase">FUERZA</p>
            <p>|</p>
            <p id="texto-camb-2" class="texto-uppercase">FLEXIBILIDAD</p>
            <p>|</p>
            <p id="texto-camb-3" class="texto-uppercase">FLUIDEZ</p>
          </div>
        </div>
      </section>

      <section class="section coaches-section">
        <div class="container">
          <h2>CONOCE A NUESTRAS <span>Coaches</span></h2>
          <div class="slider-container-global">
            <p class="flecha-slider fi" id="prev">
              <</p>

            <div class="slider-container">
              <div class="slider" id="slider">
              <div class="slide" data-disciplina="PILATES">
                  <div class="sli1"> <img src="assets/images/coaches/pro/6.png" alt="imagen slider"></div>
                  <a href="coaches.php#connie"><p>CONNIE</p></a>
                  
                </div>
               
                <div class="slide" data-disciplina="SCULPT">
                  <div class="sli1"><img src="assets/images/coaches/pro/1.png" alt="imagen slider"></div>
                  <a href="coaches.php#dulce"><p>DULCE</p></a>
                
                </div>
                <div class="slide" data-disciplina="BARRE">
                 <div class="sli1" >
                  <img src="assets/images/coaches/pro/2.png" alt="imagen slider">
                 </div>
                  <a href="coaches.php#katia"><p>KATYA</p></a>
                  
                </div>
                <div class="slide" data-disciplina="YOGA">
                  <div class="sli1"><img src="assets/images/coaches/pro/4.png" alt="imagen slider"></div>
                  <a href="coaches.php#regina"><p>REGINA</p></a>
                  
                </div>
                <div class="slide" data-disciplina="YOGA">
                  <div class="sli1"><img src="assets/images/coaches/pro/10.png" alt="imagen slider"></div>
                  <a href="coaches.php#maria"><p>MARÍA</p></a>
               
                </div>
                <div class="slide" data-disciplina="BARRE">
                  <div class="sli1"><img src="assets/images/coaches/pro/5.png" alt="imagen slider"></div>
                  <a href="coaches.php#danyfer"><p>DANYFER</p></a>
               
                </div>
                <div class="slide" data-disciplina="SCULPT">
                  <div class="sli1"><img src="assets/images/coaches/pro/8.png" alt="imagen slider"></div>
                  <a href="coaches.php#beto"><p>BETO</p></a>
                 
                </div>
                <div class="slide" data-disciplina="BARRE">
                  <div class="sli1"><img src="assets/images/coaches/pro/9.png" alt="imagen slider"></div>
                  <a href="coaches.php#karina"><p>KARINA</p></a>
                  
                </div>
                <div class="slide" data-disciplina="BARRE">
                  <div class="sli1"><img src="assets/images/coaches/pro/3.png" alt="imagen slider"></div>
                  <a href="coaches.php#gali"><p>GALI</p></a>
               
                </div>
                <div class="slide" data-disciplina="BALLET">
                  <div class="sli1"><img src="assets/images/coaches/pro/13.png" alt="imagen slider"></div>
                  <a href="coaches.php#reginas"><p>REGINA</p></a>
                  <p></p>
                </div>
              </div>
            </div>

            <p class="flecha-slider fd" id="next">></p>
          </div>
         <a href="disciplinas.php"> <p class="coaches-slider-discipline">SENCIA</p></a> 
        </div>
      </section>

      <section class="section membresias-section">
        <div class="container">
          <h2>CONOCE A NUESTRAS <span>Membresías</span></h2>
          <div class="cards-container">
            <div class="card">
              <p class="tipo-card">FLOW</p>
              <p class="numero-clases-card">4</p>
              <p class="clases-card">CLASES</p>
              <p class="precio-card">MX $650</p>
              <p class="vigencia-card">Vigencia 15 días</p>
              <a href="paquetes.php">COMPRAR</a>
            </div>
            <div class="card">
              <p class="tipo-card">ELEVATE</p>
              <p class="numero-clases-card">12</p>
              <p class="clases-card">CLASES</p>
              <p class="precio-card">MX $1,699</p>
              <p class="vigencia-card">Vigencia 30 días</p>
              <a href="paquetes.php">COMPRAR</a>
            </div>
            <div class="card">
              <p class="tipo-card">DÚO</p>
              <p class="numero-clases-card">22</p>
              <p class="clases-card">CLASES</p>
              <p class="precio-card">MX $2,860</p>
              <p class="vigencia-card">Vigencia 30 días</p>
              <a href="paquetes.php">COMPRAR</a>
            </div>
          </div>
          <a href="paquetes.php" class="ver-mas-paquetes-btn">VER MÁS PAQUETES</a>
        </div>
      </section>

      <section class="section preguntas-section">
        <div class="container">
          <h2>PREGUNTAS FRECUENTES</h2>

          <div class="preguntas-container">
            <button class="accordion">
              <p>¿Puedo hacer ejercicio si tengo alguna lesión?</p>
            </button>
            <div class="panel">
              <p>Sí. Es importante que nos informes con anticipación. Nuestras instructoras están capacitadas para adaptar los ejercicios según tus necesidades. Siempre consulta previamente con tu médico antes de iniciar cualquier actividad física.</p>
            </div>

            <button class="accordion">
              <p>¿Puedo practicar estas disciplinas si estoy embarazada o en etapa de posparto?</p>
            </button>
            <div class="panel">
              <p>Sí, ofrecemos clases adaptadas para mujeres embarazadas o en proceso de recuperación postparto, siempre con autorización médica. Es importante contar con autorización médica antes de comenzar.</p>
            </div>

            

            <button class="accordion">
              <p>¿Necesito experiencia previa para empezar?</p>
            </button>
            <div class="panel">
              <p>No. Nuestras clases están diseñadas para todos los niveles. Las instructoras te guiarán y ajustarán los movimientos según tus capacidades. No necesitas experiencia previa para comenzar.</p>
            </div>
            <button class="accordion">
              <p>¿Qué debo llevar a clase?</p>
            </button>
            <div class="panel">
              <p> Ropa cómoda que te permita moverte con libertad. Recomendamos el uso de calcetines antideslizantes para mayor seguridad.</p>
            </div>
            <button class="accordion">
              <p>¿Cuántas veces a la semana debería tomar clases?</p>
            </button>
            <div class="panel">
              <p>Para obtener resultados visibles y sentir los beneficios físicos y mentales, recomendamos practicar al menos 2 veces por semana.</p>
            </div>
            <button class="accordion">
              <p>¿Cuánto duran las clases?</p>
            </button>
            <div class="panel">
              <p>La mayoría de nuestras clases tienen una duración de entre 50 y 60 minutos.</p>
            </div>
            <button class="accordion">
              <p>¿Se requiere reservar o puedo llegar directamente?</p>
            </button>
            <div class="panel">
              <p>Es necesario reservar tu lugar con anticipación, ya que los espacios son limitados para garantizar una atención personalizada.</p>
            </div>
            <button class="accordion">
              <p>¿Puedo cancelar o reprogramar una clase?</p>
            </button>
            <div class="panel">
              <p>Sí. Aceptamos cancelaciones con al menos 6 horas de anticipación (ajustable según política). De lo contrario, la clase se considerará como tomada.</p>
            </div>
            <button class="accordion">
              <p>¿Cuál es la edad mínima para asistir a clases?</p>
            </button>
            <div class="panel">
              <p>A partir de los 13 años, con autorización de un adulto o tutor.</p>
            </div>
            <button class="accordion">
              <p>¿Cómo reservo una clase?</p>
            </button>
            <div class="panel">
              <p>Puedes reservar a través de nuestra página web, app, o directamente por WhatsApp o teléfono.</p>
            </div>
            <button class="accordion">
              <p>¿Cuáles son los métodos de pago aceptados?</p>
            </button>
            <div class="panel">
              <p>Aceptamos tarjeta de crédito/débito, pagos en efectivo y transferencias bancarias.</p>
            </div>
            <button class="accordion">
              <p>¿Qué tipo de clases ofrece Sencia?</p>
            </button>
            <div class="panel">
              <p>Todas nuestras clases son de bajo impacto y están diseñadas para fortalecer cuerpo y mente. Ofrecemos: <br>
                • Pilates Mat <br>
                • Barre <br>
                • Sculpt <br>
                • Yoga <br>
                Puedes consultar la descripción de cada clase para saber cuál se adapta mejor a tus objetivos.
              </p>
            </div>
          </div>
          <a class="ayuda-btn" href="contacto.php">AYUDA</a>
        </div>
      </section>

    </article>
  </main>
  <?php include 'footer.php'; ?>
  <a href="https://wa.me/524792179429?text=Hola,%20Quiero%20m%C3%A1s%20informaci%C3%B3n%20de%20SENCIA." class="back-top-btn" aria-label="back to top"
    data-back-top-btn>
    <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp ">
  </a>
  <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
  <script type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include 'script.php'; ?>
  <script>
    cambiarTextoVideo(pilatesTab);
  </script>
</body>

</html>