<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubarre</title>
  <meta name="title" content="Sencia Studio">
  <meta name="description" content="SENCIA es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral.">
  <link rel="shortcut icon" href="./favicon.png" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/estilos_ubarre.css?v=<?php echo time(); ?>">
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
    <article class="beneficios-barre">
        <img src="./assets/images/ubarre/ubarre-blanco.svg" alt="">
        <div class="beneficios-del-barre">
            <div class="titulo-beneficios">
                <h3>Beneficios del barre</h3>
            </div>
            <div class="listado-beneficios">
                <div class="linea-beneficios">
                    <div class="punto"></div>
                    <div class="punto"></div>
                    <div class="punto"></div>
                </div>
                <div>
                    <div class="texto-beneficios">
                        <div class="beneficio-container">
                            <h4>Tonificación</h4>
                        </div>
                        <p>Fortalece músculos y esculpe el cuerpo.</p>
                    </div>
                    <div class="texto-beneficios">
                        <div class="beneficio-container">
                            <h4>Postura</h4>
                        </div>
                        <p>Mejora el equilibrio y la alineación corporal.</p>
                    </div>
                    <div class="texto-beneficios">
                        <div class="beneficio-container">
                            <h4>Flexibilidad</h4>
                        </div>
                        <p>Aumenta la movilidad y rango de movimiento</p>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <article class="beneficios-section-texto">
        <div class="elemento-top-beneficios">
            <img src="./assets/images/ubarre/svg/dots.svg" alt="">
        </div>
        <div class="texto-central-beneficios">
            <h3>BARRE</h3>
            <p>El barre es un entrenamiento que combina ballet, pilates y ejercicios
                de fuerza, usando una barra para tonificar músculos, mejorar la
                postura y aumentar la flexibilidad. Es de bajo impacto y muy
                efectivo para esculpir el cuerpo.
            </p>
            <div class="wellness-beneficios">
                <p>Wellness made for</p>
                <img src="./assets/images/ubarre/svg/u-sola.svg" alt="">
            </div>
        </div>
        <div class="elemento-bottom-beneficios">
            <p>REVIVING THE 
            <br>MINDFUL MOVEMENT</p> 
        </div>
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