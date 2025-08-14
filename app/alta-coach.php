<?php

include 'procesar_coach.php';

session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SenciaApp</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="./favico.png" type="image/x-icon" />
    <script src="./assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['./assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/plugins.min.css">
    <link rel="stylesheet" href="./assets/css/next.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="./assets/css/demo.css">
    <style>
        .icon {
            fill: #fff;
            width: 60px;
        }
    </style>
</head>

<body>
    <div class="wrapper sidebar_minimize">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <?php include 'navbar.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Agregar Coach</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="coach.php">Coaches</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Agregar Coach</a>
                            </li>

                        </ul>
                    </div>
                    <div id="form-disc" class="container-sm w-50 form-control p-5 mt-5">
                        <form action="procesar_coach.php" method="POST" class="needs-validation" enctype="multipart/form-data">
                            <input type="text" id="nombre_coach" name="nombre_coach" placeholder="Nombre del Coach (Solo primer Nombre)..." class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                            <textarea name="desc_coach" id="desc_coach" class="form-control no-resize mb-3 p-3 bg-body-secondary" placeholder="Ingresa la Descripción del Coach..." ></textarea>
                             <select name="nombre_disc" id="nombre_disc" class="form-control mt-3 bg-body-secondary p-3" required>
                                <?php
                                $queryD = "SELECT id, nombre_disciplina FROM disciplinas";
                                $resultD = $conn->query($queryD);
                                
                                if ($resultD->num_rows > 0) {
                                   
                                    while ($rowD = $resultD->fetch_assoc()) {
                                        echo '<option value="' . $rowD['id'] . '">' . htmlspecialchars($rowD['nombre_disciplina']) . '</option>';
                                    }
                                   
                                } else {
                                    echo 'No hay disciplinas disponibles.';
                                }
                                
                                
                                ?>
                            </select>
                            
                            <select name="activo" id="activo" class="form-control mt-3 bg-body-secondary p-3" required>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <label for="imagen" class="my-3">SUBE UNA IMAGEN DEL COACH</label>
                            <input type="file" id="imagen" name="imagen" class="form-control mt-0 p-3 bg-body-secondary" accept=".png" onchange="mostrarVistaPrevia(event)" >
                            <div class="d-flex justify-content-center">
                                <img id="vistaPrevia" style="max-width: 50%; margin-top: 20px; border-radius: 15px; box-shadow: 1px 5px 12px #00000054;">
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <input type="submit" value="Agregar Coach" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.nexxu.mx">
                                    Soporte
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <div class="copyright ms-auto">
                        <a href="http://www.nexxu.mx"><img src="https://nexxu.mx/./assets/images/logo-n.svg" style="width: 80px;" alt=""></a>
                    </div>
                </div>
            </footer>
        </div>


    </div>
    <script src="./assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="./assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="./assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="./assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="./assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="./assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="./assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="./assets/js/next.min.js"></script>

    <script src="./assets/js/diciplinas.js?v=<?php echo time(); ?>"></script>

    <script>
        function mostrarVistaPrevia(event) {
            const img = document.getElementById('vistaPrevia');
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>

</html>