<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>üBarre</title>
  <meta name="title" content="üBarre">
  <meta name="description" content="üBarre un punto de encuentro. Cada clase, saludo y conversación construyen una comunidad que escucha, sostiene y acompaña.">
  <link rel="shortcut icon" href="./assets/images/ubarre/favicon_ubarre.png" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&display=swap" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/estilos_ubarre.css?v=<?php echo time(); ?>">
  <?php include 'head.php'; ?>
  <style>
    .vosj {
      width: 101%;
      height: auto;
    }

    @media (min-width: 767px) {
      .vosj {
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
            poster="./assets/images/bg-vid.jpg">
            <source src="./assets/images/bg-class.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <div class="bg-b"></div>
        <div class="container">
          <div class="hero-banner-elements">
            <div class="img-banner-container">
              <img src="./assets/images/ubarre/svg/ubarre-sin-tagline.svg"
                alt="übarre Logo">
            </div>
            <h1>
              The new era
              of movement
            </h1>
            <a href="reserva.php" class="reservar-btn-banner">RESERVAR</a>
          </div>
        </div>
      </section>

      <section class="fondo-fundadoras">
        <div class="fundadoras-section container">
          <div class="elementos-izquierda-fundadoras">
            <div class="elemento-top-fundadoras">
              <img src="./assets/images/ubarre/svg/dots.svg" alt="">
            </div>
            <div class="elemento-bottom-fundadoras">
              <h4>Fundadoras</h4>
            </div>
          </div>
          <div class="elemento-central-fundadoras" >
            <div class="fundadoras-nombre">
              <p>Nuestra misión
                <br>y visión
              </p>
              <img src="./assets/images/ubarre/svg/ubarre-sin-tagline.svg" alt="">
            </div>
          </div>
          <div class="elementos-derecha-fundadoras">
            <div class="elemento-top-fundadoras fila-izquierda">
              <img src="./assets/images/ubarre/svg/icon.svg" alt="">
            </div>
            <div class="elemento-bottom-fundadoras">
              <p>REVIVING THE
                <br>MINDFUL MOVEMENT
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="descripcion-section">
        <video id="video-index-texto" src="" autoplay loop muted playsinline disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback"></video>
        <div class="container section">
          <img src="assets/images/ubarre/svg/icon.svg" alt="logo übarre">
          <p>
            Transformamos el movimiento en un punto de encuentro. Cada clase, saludo y conversación construyen una comunidad que
            escucha, sostiene y acompaña.
          </p>
          <p>
            Buscamos tu bienestar real: físico, mental y emocional. Porque no se trata solo de moverse, sino de como te
            sientes al hacerlo. Muevete con intención. Conectate con el corazón.
          </p>
          <div class="wellness-texto">
            <p>Wellness made for</p>
            <img src="./assets/images/ubarre/svg/u-sola.svg" alt="">
          </div>
          <a href="aboutus.php">Conocer más</a>
        </div>
      </section>

      <!--<section class="desciplinas-section">
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
    -->
      <section class="coaches-section">
        <div class="">
          <div class="slider-container-global">
            <p class="flecha-slider fi" id="prev">
              < </p>

                <div class="slider-container">
                  <div class="slider" id="slider">

                    <?php
                    include 'db.php';
                    $selectCoachesStmt = $conn->prepare("SELECT id, nombre_coach FROM coaches");
                    $selectCoachesStmt->execute();
                    $resultadoSelectCoaches = $selectCoachesStmt->get_result();

                    while ($filaCoach = $resultadoSelectCoaches->fetch_assoc()) {
                      echo '
                      <div class="slide" data-disciplina="PILATES">
                        <div class="sli1"> <img src="assets/images/coaches/pro/' . $filaCoach['id'] . '.png?v=' . time() . '" alt="imagen slider"></div>
                        <div class="contenido-slider">
                          <div class="texto-slider">
                            <p>' . $filaCoach['nombre_coach'] . '</p>
                            <a href="coaches.php#' . strtolower($filaCoach['nombre_coach']) . '">Conocer</a>
                          </div>
                        </div>

                      </div>
                      ';
                    }
                    ?>
                  </div>
                </div>

                <p class="flecha-slider fd" id="next">></p>

                <div class="texto-slider-final">
                  <p>Nuestras Coaches</p>
                  <a href="reserva.php">RESERVA CON ELLAS</a>
                </div>
          </div>
        </div>
      </section>

      <section class="section membresias-section">
        <div class="container">
          <h2>Conoce nuestras membresías</h2>
          <div class="cards-container">
             <?php
                    
                    $sqlp = $conn->prepare("SELECT id, clases, nombre, costo, vigencia, smoothies, total_smoothies FROM paquetes ORDER BY RAND() LIMIT 3");
                    $sqlp->execute();
                    $resp = $sqlp->get_result();

                    while ($filaPaq = $resp->fetch_assoc()) {
                      
                      if($filaPaq['smoothies'] == 0){
                        $smot = 'No incluye Smoothies';
                      }else{
                        $smot = '<p class"numero-smoothies">Incluye ' . $filaPaq['total_smoothies'] . ' Smoothies</p>';
                      }
                      echo '
                      <div class="card">
                        <p class="tipo-card">' . $filaPaq['nombre'] . '</p>
                        <p class="numero-clases-card">' . $filaPaq['clases'] . '</p>
                        <p class="clases-card">CLASES</p>
                        ' . $smot . '
                        <p class="precio-card">MX $' . $filaPaq['costo'] . '</p>
                        <p class="vigencia-card">Vigencia ' . $filaPaq['vigencia'] . ' días</p>
                        <a href="checkout.php?tkn=ECvRPgke49NltqX85XH1C3zZ5kp4Z9wlaG4yPAQ3lY0Dw0G7Y3fhBZelmEN571HwJPJ6yY5G9rbPsgDIn6FTCWK5xSJ9Jp5GC8T4RTvNWfWVVIfj49srNoJsDR0ok1WQrY9T&id=' . $filaPaq['id'] . '">COMPRAR</a>
                      </div>
                      ';
                    }
              ?>
            
          </div>
          <a href="paquetes.php" class="ver-mas-paquetes-btn">VER MÁS PAQUETES</a>
        </div>
      </section>

      <section class="section preguntas-section">
        <div class="fundadoras-section container preguntas-version">
          <div class="elementos-izquierda-fundadoras">
            <div class="elemento-top-fundadoras">
              <img src="./assets/images/ubarre/svg/dots.svg" alt="">
            </div>
            <div class="elemento-bottom-fundadoras">
              <h4>Preguntas</h4>
            </div>
          </div>
          <div class="elemento-central-preguntas">
            <h2>PREGUNTAS FRECUENTES</h2>

            <div class="preguntas-container">
              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Puedo asistir si tengo una lesión o una condición médica?</p>
                </button>
                <div class="panel">
                  <p>Sí, siempre que tengas autorización médica. Te pedimos avisarnos antes de tu clase para poder adaptar los ejercicios según tus necesidades y cuidar tu seguridad.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Puedo practicar estas disciplinas si estoy embarazada o en etapa de postparto?</p>
                </button>
                <div class="panel">
                  <p>Sí, ofrecemos clases adaptadas para mujeres embarazadas o en proceso de recuperación postparto, siempre con autorización médica. Es importante contar con autorización médica antes de comenzar.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Necesito tener experiencia previa para tomar una clase de Barre?</p>
                </button>
                <div class="panel">
                  <p>Todas nuestras clases están diseñadas para que puedas unirte sin importar tu nivel. Nuestros entrenamientos te permitirán avanzar a tu propio ritmo, con guía constante por parte del equipo.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Qué ropa o accesorios debo llevar?</p>
                </button>
                <div class="panel">
                  <p>Te recomendamos usar ropa deportiva cómoda que te permita moverte libremente. Los calcetines con antiderrapante son ideales para una mejor estabilidad durante la clase.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Cuál es la duración de las clases?</p>
                </button>
                <div class="panel">
                  <p>Cada clase tiene una duración aproximada de 50 a 60 minutos.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Es necesario reservar mi clase o puedo llegar directo al estudio?</p>
                </button>
                <div class="panel">
                  <p>Sí, es necesario reservar con anticipación. Nuestras clases tienen cupo limitado para garantizar una experiencia más personalizada.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Puedo cancelar o reprogramar una clase?</p>
                </button>
                <div class="panel">
                  <p>Sí. Aceptamos cancelaciones con al menos 8 horas de anticipación. De lo contrario, la clase se considerará como tomada.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Cuál es la edad mínima para asistir a clases?</p>
                </button>
                <div class="panel">
                  <p>Recibimos a personas desde los 12 años, siempre y cuando puedan alcanzar la barra cómodamente. Si tienes dudas, podemos ayudarte a evaluar si es el momento adecuado.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Cómo reservo una clase?</p>
                </button>
                <div class="panel">
                  <p>Puedes reservar a través de nuestra página web, por WhatsApp o mostrador antes de tu clase contando con tu referencia de pago.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Cuáles son los métodos de pago aceptados?</p>
                </button>
                <div class="panel">
                  <p>Aceptamos tarjeta de crédito/débito, pagos en efectivo y transferencias bancarias.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Puedo hacer cambios o agregar algo a mi bebida del bar?</p>
                </button>
                <div class="panel">
                  <p>Sí, cualquier modificación especial la puedes solicitar directamente en mostrador. También puedes agregar extras a tu bebida con un costo adicional.</p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Cuáles son los horarios de atención en el estudio?</p>
                </button>
                <div class="panel">
                  <p> Estamos disponibles en dos horarios: por las mañanas de Lunes a Viernes de 6:30 a.m. a 10:30 a.m., y por las tardes de 5:00 p.m. a 9:00 p.m, Sábados de 7:00 a.m. a 11:00 a.m. y Domingo de 8:00 a.m. a 12:00 p.m.
                  </p>
                </div>
              </div>

              <div class="container-accordion">
                <button class="accordion">
                  <p>¿Qué tipo de clases encuentro en Ü Barre?</p>
                </button>
                <div class="panel">
                  <p> Todas nuestras clases están basadas en Barre, una disciplina de bajo impacto que combina lo mejor del ballet, pilates y entrenamiento funcional. Ofrecemos diferentes formatos diseñados para trabajar fuerza, flexibilidad, resistencia y alineación postural, con opciones tanto para principiantes como para avanzado.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="elementos-derecha-fundadoras">
            <div class="elemento-top-fundadoras fila-izquierda">
              <img src="./assets/images/ubarre/svg/icon.svg" alt="">
            </div>
            <div class="elemento-bottom-fundadoras">
              <p>REVIVING THE
                <br>MINDFUL MOVEMENT
              </p>
            </div>
          </div>
        </div>
        <div class="container">

        </div>
      </section>

    </article>
  </main>
  <?php include 'footer.php'; ?>

  <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
  <script type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include 'script.php'; ?>
</body>

</html>