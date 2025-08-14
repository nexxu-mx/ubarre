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
</head>

<body id="top">
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php include 'ofer.php'; ?>
    <?php include 'header.php'; ?>
    

    <main>
        <article>
            <section class="main-section-contacto" style="background: var(--danyfer-karina-color);">
                <div class="container">
                    <div class="general-form-container" style="box-shadow: 0 15px 12px 1px #0000004d;">
                        <div class="logo-form-container">
                            <img src="assets/images/svg/logo-blanco-con-tagline.svg" alt="Logo Sencia">
                        </div>
                        <div class="form-container">
                            <form action="">
                                <input type="text" placeholder="Nombre" name="nombre" id="nombre">
                                <input type="text" placeholder="Email Address" name="email" id="email">
                                <input type="text" placeholder="Teléfono" name="telefono" id="telefono">
                                <textarea name="mensaje" id="mensaje" placeholder="Escribe tu mensaje aquí"></textarea>
                                <input class="submit-btn" type="submit" value="ENVIAR">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="map-section">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.48616126287!2d-101.60334352548601!3d21.053236380602222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842b97006111dc6f%3A0x70d49a867c0ec288!2sSENCIA%20STUDIO!5e0!3m2!1ses!2smx!4v1744227255602!5m2!1ses!2smx"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="map-section-bottom"></div>
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