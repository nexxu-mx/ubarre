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
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php include 'ofer.php'; ?>

    <?php include 'header.php'; ?>

    <main>
        <article>
            <section class="banner-about-us-section">
                <div class="container">
                    <div class="logo-banner-about-us-container">
                        <img src="assets/images/svg/logo-blanco.svg" alt="Logo Sencia">
                    </div>
                </div>
            </section>

            <section class="descripcion-section">
                <div class="container section">
                    <div>
                        <img src="assets/images/svg/logo-negro-sin-tagline.svg" alt="logo sencia">
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
                            <img src="./assets/images/svg/down.svg" alt="">
                        </div>
                        <a href="">Conocer más</a>
                    </div>
                </div>
            </section>

            <section class="aboutus-fundadoras-fondo">
                <div class="aboutus-fundadoras container ">
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
                    <div class="aboutus-middle">
                        <div class="elemento-central-fundadoras">
                            <div class="button-fundadoras">
                            <button>
                                <ion-icon name="menu-outline" style="color: #fdfdfdff;"></ion-icon>
                            </button>
                            </div>
                            <div class="fundadoras-nombre">
                            <p>Nuestra misión 
                                <br>y visión</p>
                            <img src="./assets/images/svg/logo-blanco.svg" alt="">
                            </div>
                        </div>
                        <div class="texto-aboutus-middle">
                            <h3>Nuestras Fundadoras</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna
                            aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi
                            ut aliquip ex ea commodo consequat.
                            Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu</p>
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