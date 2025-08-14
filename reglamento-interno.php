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
    <style>
       .tyc p {
        font-size: 14px;
       }
    </style>
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

            <section class="section">
                <div class="container tyc">
               
                </div>
            </section>

           
        </article>
    </main>
    <?php include 'footer.php'; ?>
    <a href="https://wa.me/524792179429?text=Hola,%Quiero%20más%20información%20de%20SENCIA." class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp">
    </a>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php include 'script.php'; ?>
</body>

</html>