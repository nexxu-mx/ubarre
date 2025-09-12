<?php

session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

    header("Location: ../login.php");
    exit;
}

include '../db.php';

//Declarar variables 
$sabor = "";
$button = "Agregar Smoothie";
$idSmoothieEdit = 0;

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
                        <h3 class="fw-bold mb-3">Agregar Smoothie</h3>
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
                                <a href="smoothies.php">Smoothie</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Agregar Smoothie</a>
                            </li>
                        </ul>
                    </div>

                    <div id="form-disc" class="container-sm w-50 form-control p-5 mt-5">
                        <form action="procesar_smoothie.php" method="POST" enctype="multipart/form-data">
                            <?php

                            if (isset($_GET['id'])) {
                                $idSmoothieEdit = $_GET['id'];

                                $selectSmoothie = $conn->prepare("SELECT id, sabor, descrip FROM smoothies WHERE id = ?");
                                $selectSmoothie->bind_param("i", $idSmoothieEdit);
                                $selectSmoothie->execute();
                                $resultadoSelectSmoothie = $selectSmoothie->get_result();

                                if ($resultadoSelectSmoothie->num_rows > 0) {
                                    $filaSelectSmoothie = $resultadoSelectSmoothie->fetch_assoc();
                                    $sabor = $filaSelectSmoothie['sabor'];
                                    $descrip = $filaSelectSmoothie['descrip'];
                                    $button = "Guardar Edición";

                                    // Cambiar el título y breadcrumb para edición
                                    echo '<script>
                                        document.querySelector(".page-header h3").textContent = "Editar Smoothie";
                                        document.querySelector(".breadcrumbs .nav-item:last-child a").textContent = "Editar Smoothie";
                                    </script>';
                                }
                            } else {
                                // Valores por defecto para NUEVO smoothie
                                $sabor = "";
                                $descrip="";
                                $button = "Agregar Smoothie";
                                $idSmoothieEdit = 0;
                            }
                            ?>
                            <input type="text" id="sabor_smoothie" name="sabor_smoothie" placeholder="Sabor del Smoothie..." class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" value="<?php echo htmlspecialchars($sabor); ?>" required>

                            <label for="descrip_smoothie" class="my-3">Descripción del smoothie</label>
                            <textarea name="descrip_smoothie" id="descrip_smoothie" placeholder="Ejemplo: Leche entera + Moka + Plátano + Proteína de chocolate + Nibs de cacao" 
                                rows="4" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary"><?php echo htmlspecialchars($descrip)?></textarea>

                            <label for="imagen-smoothie" class="my-3">Sube la foto del Smoothie</label>
                            <input type="file" id="imagen-smoothie" name="imagen-smoothie" class="form-control mt-0 p-3 bg-body-secondary" accept="image/*" onchange="mostrarVistaPrevia(event)">
                            <div class="d-flex justify-content-center">
                                <video id="vistaPrevia" style="max-width: 50%; margin-top: 20px;" autoplay muted></video>
                            </div>
                            <input type="hidden" value="<?php echo $idSmoothieEdit; ?>" id="id_smoothie_edit" name="id_smoothie_edit" />

                            <div class="d-flex justify-content-end g-2 mt-3" style="gap: 10px">
                                <button type="button" class="btn btn-danger" onclick="deleteSmoothie(<?php echo isset($idSmoothieEdit) ? $idSmoothieEdit : 'null'; ?>)">Eliminar</button>
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

    <script>
        function deleteSmoothie(id) {
            fetch('delete-smoothie.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        window.location.href = 'smoothies.php';
                    } else {
                        alert('Error al eliminar el smoothie: ' + data);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    alert('Ocurrió un error al enviar la solicitud.');
                });
        }
    </script>

</body>

</html>