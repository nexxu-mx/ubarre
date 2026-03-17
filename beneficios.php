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
        <article class="beneficios-barre">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 130rem; z-index: -1; display: flex; justify-content: center; align-items: center;">
                        <video autoplay loop muted playsinline style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; object-fit: cover; transform: translate(-50%, -50%);z-index: 2"
                            poster="./assets/images/bg-vid.jpg">
                            <source src="./assets/images/bg-class.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
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
                        <div class="punto"></div>
                        <div class="punto"></div>
                        <div class="punto"></div>
                        <div class="punto"></div>
                        <div class="punto"></div>
                        <div class="punto"></div>
                    </div>
                    <div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Fuerza</h4>
                            </div>
                            <p>Fortalece músculos de: piernas, abdomen y brazos.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Resistencia</h4>
                            </div>
                            <p>Aumenta la capacidad de mantener posturas y movimientos.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Tonificación</h4>
                            </div>
                            <p>Mejora el aspecto y firmeza de tus músculos.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Estabilidad</h4>
                            </div>
                            <p>Mejora tu equilibrio y control corporal al trabajar con movimientos precisos y conscientes.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Movilidad</h4>
                            </div>
                            <p>Incrementa el rango de movimiento en las articulaciones.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Postura</h4>
                            </div>
                            <p>Mejora la forma en que te mueves día a día.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Flexibilidad</h4>
                            </div>
                            <p>Aumenta la elasticidad de tejidos musculares de forma progresiva.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container" style="width: 300px;">
                                <h4>Conexión mente-cuerpo</h4>
                            </div>
                            <p>Te ayuda a estar presente, celebrando cada avance de tu cuerpo.</p>
                        </div>
                        <div class="texto-beneficios">
                            <div class="beneficio-container">
                                <h4>Bajo impacto</h4>
                            </div>
                            <p>Cuida tus articulaciones mientras te desafía físicamente.</p>
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
                    <br>MINDFUL MOVEMENT
                </p>
            </div>
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
        cambiarTextoVideo(pilatesTab);
    </script>
</body>

</html>