<!--                                                                                                
                    🚀 Desarrollado por 🚀

███╗   ██╗███████╗██╗  ██╗██╗  ██╗██╗  ██╗    ███╗   ███╗██╗  ██╗
████╗  ██║██╔════╝╚██╗██╔╝╚██╗██╔╝██║  ██║    ████╗ ████║╚██╗██╔╝
██╔██╗ ██║█████╗   ╚███╔╝  ╚███╔╝ ██║  ██║    ██╔████╔██║ ╚███╔╝ 
██║╚██╗██║██╔══╝   ██╔██╗  ██╔██╗ ██║  ██║    ██║╚██╔╝██║ ██╔██╗ 
██║ ╚████║███████╗██╔╝ ██╗██╔╝ ██╗███████║    ██║ ╚═╝ ██║██╔╝ ██╗
╚═╝  ╚═══╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝╚══════╝ ██ ╚═╝     ╚═╝╚═╝  ╚═╝                                                                                             
-->

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>übarre | Clases</title>
  <meta name="title" content="übarre">
  <meta name="description" content="üBarre un punto de encuentro. Cada clase, saludo y conversación construyen una comunidad que escucha, sostiene y acompaña.">
  <link rel="shortcut icon" href="./assets/images/ubarre/favicon_ubarre.png" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <?php include 'head.php'; ?>
</head>

<body id="top">
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>

  <?php include 'ofer.php'; ?>

  <?php include 'header.php'; ?>

  <?php include 'db.php'; ?>

  <main>
    <article>
      <section class="main-section">
        <?php
        $query = "SELECT id, nombre_disciplina, descripcion_disciplina, subdescripcion_texto1, subdescripcion_texto2, subdescripcion_texto3 FROM disciplinas";

        $resultado = $conn->query($query);

        while ($fila = mysqli_fetch_assoc($resultado)) {
          // 

          echo '
                        <div class="class-section section color-class">
                            <div class="container">
                                <div class="texto-clases-container">
                                    <h2><span>' . $fila['nombre_disciplina'] . '</span></h2>
                                    <p>' . $fila['descripcion_disciplina'] . '</p>
                                    <a href="reserva.php">MUÉVETE CON NOSOTROS</a>
                                </div>
                                <div class="video-clases-container">
                                  
                                   <video autoplay loop muted playsinline data-reveal-videos-disciplines>
                                      <source src="./assets/images/disciplinas/' . $fila['id'] . '.mp4?v=' . time() . '" type="video/mp4">
                                      Your browser does not support the video tag.
                                  </video>
                                    <div class="texto-video-clases-container">
                                        <p>' . $fila['subdescripcion_texto1'] . '</p>
                                        <p>|</p>
                                        <p>' . $fila['subdescripcion_texto2'] . '</p>
                                        <p>|</p>
                                        <p>' . $fila['subdescripcion_texto3'] . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
        }
        ?>
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
  <script>


  </script>

</body>

</html>