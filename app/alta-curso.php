<?php

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
                        <h3 class="fw-bold mb-3">Agregar Disciplina</h3>
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
                                <a href="diciplinas.php">Disciplinas</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Agregar Disciplina</a>
                            </li>

                        </ul>
                    </div>
                    <div id="form-disc" class="container-sm w-50 form-control p-5 mt-5">
                        <form action="procesar_disciplina.php" method="POST" enctype="multipart/form-data">
                            <?php
                            include '../db.php';

                            if (isset($_GET['id'])) {
                               
                                $idDisciplinaEdit = $_GET['id'];

                                $selectDisciplina = $conn->prepare("SELECT id, nombre_disciplina, descripcion_disciplina, subdescripcion_texto1, subdescripcion_texto2, subdescripcion_texto3, id_coach, activo FROM disciplinas WHERE id = ?");
                                $selectDisciplina->bind_param("i", $idDisciplinaEdit);
                                $selectDisciplina->execute();
                                $resultadoSelectDisciplina = $selectDisciplina->get_result();

                                $filaSelectDisciplina = $resultadoSelectDisciplina->fetch_assoc();

                                $selectCoach = $conn->prepare("SELECT id, nombre_coach, descripcion_coach, id_disciplina, activo FROM coaches WHERE id = ?");
                                $selectCoach->bind_param("i", $filaSelectDisciplina['id_coach']);
                                $selectCoach->execute();
                                $resultadoSelectCoach = $selectCoach->get_result();

                                $filaSelectCoach = $resultadoSelectCoach->fetch_assoc();
                                $button = "Guardar Edición";
                                $nombreDisciplina = $filaSelectDisciplina['nombre_disciplina'];
                                $descDisc = $filaSelectDisciplina['descripcion_disciplina'];
                                $subdesctext1 = $filaSelectDisciplina['subdescripcion_texto1'];
                                $subdesctext2 = $filaSelectDisciplina['subdescripcion_texto2'];
                                $subdesctext3 = $filaSelectDisciplina['subdescripcion_texto3'];
                                $idCoach = $filaSelectDisciplina['id_coach'];
                                $activo = $filaSelectDisciplina['activo'];

                            } else{
                                $button = "Agregar Disciplina";
                                $nombreDisciplina = "";
                                $descDisc = "";
                                $subdesctext1 = "";
                                $subdesctext2 = "";
                                $subdesctext3 = "";
                                $idCoach = "";
                                $activo = "";
                            }
                            ?>
                            <input type="text" id="nombre_disc" name="nombre_disc" placeholder="Nombre de la Disciplina..." class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" value="<?php echo $nombreDisciplina;?>" required>
                                    <textarea name="desc_disc" id="desc_disc" class="form-control no-resize mb-3 p-3 bg-body-secondary" required><?php echo $descDisc;?></textarea>

                                    <div class="d-flex justify-content-lg-center gap-3 mb-3">
                                        <input type="text" id="palabra-desc-1" name="palabra-desc-1" class="p-3 flex-fill form-control bg-body-secondary" placeholder="Palabra Descriptiva 1..." required>
                                        <input type="text" id="palabra-desc-2" name="palabra-desc-2" class="p-3 flex-fill form-control bg-body-secondary" placeholder="Palabra Descriptiva 2..." required>
                                        <input type="text" id="palabra-desc-3" name="palabra-desc-3" class="p-3 flex-fill form-control bg-body-secondary" placeholder="Palabra Descriptiva 3..." required>
                                    </div>
                                    <input type="text" id="nombre_coach" name="nombre_coach" class="form-control p-3 bg-body-secondary" placeholder="Coach que la Imparte (Solo primer nombre)..." required>
                                    <label for="imagen" class="my-3">SUBE UN VIDEO DE LA DISCIPLINA</label>
                                    <input type="file" id="imagen-disciplina" name="imagen-disciplina" class="form-control mt-0 p-3 bg-body-secondary" accept=".mp4,.mov,.avi,.wmv" onchange="mostrarVistaPrevia(event)" >
                                    <div class="d-flex justify-content-center">
                                        <video id="vistaPrevia" style="max-width: 50%; margin-top: 20px;" autoplay muted></video>
                                    </div>
                                    <input type="hidden" value="0" id="id_disciplina_edit" name="id_disciplina_edit"/>
                            <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary"><?php echo $button; ?></button>
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

    <script>
        function mostrarVistaPrevia(event) {
            const video = document.getElementById('vistaPrevia');
            video.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>

</html>