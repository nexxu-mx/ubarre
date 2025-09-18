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
    <title>übarre</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="shortcut icon" href="../assets/images/ubarre/favicon_ubarre.png" type="image/svg+xml">
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
    <?php

    ?>
    <div class="wrapper sidebar_minimize">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <?php include 'navbar.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">
                            <?php
                            if (isset($_GET['id'])) {
                                echo 'Editar Paquete';
                            } else {
                                echo 'Agregar Paquete';
                            }
                            ?>
                        </h3>
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
                                <a href="paquetes.php">Paquetes</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <?php
                                    if (isset($_GET['id'])) {
                                        echo 'Editar Paquete';
                                    } else {
                                        echo 'Agregar Paquete';
                                    }
                                    ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div id="form-disc" class="container-sm w-50 form-control p-5 mt-5">
                        <form action="procesar-paquete.php" method="POST" class="needs-validation" enctype="multipart/form-data">
                            <?php
                            include '../db.php';

                            if (isset($_GET['id'])) {
                                $idPaqueteEdit = $_GET['id'];

                                $selectPaquete = "SELECT id, clases, costo, nombre, vigencia, invitados, persona, descuento, finalizadsc, smoothies, total_smoothies, ilimitado FROM paquetes WHERE id = '$idPaqueteEdit'";

                                $resultadoSelectPaquete = $conn->query($selectPaquete);

                                while ($filaPaquete = mysqli_fetch_assoc($resultadoSelectPaquete)) {
                                    echo '
                                    <label for="nombre_paquete">Nombre del Paquete:</label>
                                        <input type="text" id="nombre_paquete" name="nombre_paquete" placeholder="Agrega el Nombre del Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['nombre'] .'">
                                    
                                    <label for="ilimit_check" class="form-label">¿El Paquete es Ilimitado?</label>
                                    <div class="row align-items-center mb-3"> 

                                        <div class="col-6 d-flex align-items-center gap-3">
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="ilimit_check" name="ilimit_check" style="transform: scale(1.5);" ' . ($filaPaquete['ilimitado'] == 1 ? 'checked' : '') .'>
                                            </div>
                                                <label class="form-check-label mb-0" for="ilimit_check"></label>
                                        </div>
                                        <label for="smoothie_check" class="form-label">¿El Paquete Incluirá Smoothie?</label>
                                    <div class="row align-items-center mb-3">
                                        
                                        <div class="col-6 d-flex align-items-center gap-3">
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="smoothie_check" name="smoothie_check" style="transform: scale(1.5);" '. ($filaPaquete['smoothies'] == 1 ? 'checked' : '') .'>
                                            </div>
                                                <label class="form-check-label mb-0" for="smoothie_check">Sí Incluirá</label>
                                        </div>

                                        <div class="col-6" id="smoothieInput" style="display: none;">
                                            <input type="number" id="smoothies_paquete" name="smoothies_paquete" placeholder="Número de Smoothies" class="form-control input-group input-group-lg p-3 bg-body-secondary" min="1" max="12"  value="'. $filaPaquete['total_smoothies'] .'">
                                        </div>
                                    </div>
                                        <div class="col-12 mt-2" id="ilimitInput">
                                            <label for="numero_clases">Número de Clases:</label>
                                                <input type="text" style="text-transform: capitalize;" id="numero_clases" name="numero_clases" placeholder="Agrega el número de clases" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['clases'] .'">
                                        </div>

                                    </div>
                                    
                                    <label for="costo_paquete">Costo del Paquete:</label>
                                        <input type="text" id="costo_paquete" name="costo_paquete" placeholder="Agrega el costo del Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['costo'] .'">
                                    <label for="vigencia_paquete">Vigencia del Paquete:</label>
                                        <input type="text" id="vigencia_paquete" name="vigencia_paquete" placeholder="Agrega la vigencia del Paquete en Días" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['vigencia'] .'">
                                    
                                        <input type="text" id="invitados_paquete" name="invitados_paquete" value="0" placeholder="Agrega el Número de Invitados que puede tener el Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['invitados'] .'">
                              
                                        <input type="hidden" id="personas_paquete" name="personas_paquete" value="1" placeholder="Personas que están Invitadas al Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required value="'. $filaPaquete['persona'] .'">
                                    
                                    




                                    <label for="personas_paquete">Descuento:</label>
                                    <div style="display: flex; justify-content: center; align-items: center; gap: 20px;border: 1px solid #efefef;padding: 10px;">
                                    <input type="text" id="dsc" name="dsc" placeholder="10" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" value="'. $filaPaquete['descuento'] .'">
                                    <input type="date" id="vigen" name="vigen" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" value="'. $filaPaquete['finalizadsc'] .'">
                                    </div>
                                    <input type="hidden" id="id_paquete_edit" name="id_paquete_edit" value="'. $idPaqueteEdit .'">

                                    ';
                                }
                            } else {
                                echo '
                                    <label for="nombre_paquete">Nombre del Paquete:</label>
                                        <input type="text" id="nombre_paquete" name="nombre_paquete" placeholder="Agrega el Nombre del Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                                    
                                    <label for="ilimit_check" class="form-label">¿El Paquete es Ilimitado?</label>
                                    <div class="row align-items-center mb-3">
                                        
                                        <div class="col-6 d-flex align-items-center gap-3">
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="ilimit_check" name="ilimit_check" style="transform: scale(1.5);">
                                            </div>
                                                <label class="form-check-label mb-0" for="ilimit_check"></label>
                                        </div>
                                        <label for="smoothie_check" class="form-label">¿El Paquete Incluirá Smoothie?</label>
                                    <div class="row align-items-center mb-3">
                                        
                                        <div class="col-6 d-flex align-items-center gap-3">
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="smoothie_check" name="smoothie_check" style="transform: scale(1.5);">
                                            </div>
                                                <label class="form-check-label mb-0" for="smoothie_check">Sí Incluirá</label>
                                        </div>

                                        <div class="col-6" id="smoothieInput" style="display: none;">
                                            <input type="number" id="smoothies_paquete" name="smoothies_paquete" placeholder="Número de Smoothies" class="form-control input-group input-group-lg p-3 bg-body-secondary" min="1" max="12">
                                        </div>
                                    </div>
                                        <div class="col-12 mt-2" id="ilimitInput">
                                            <label for="numero_clases">Número de Clases:</label>
                                                <input type="text" style="text-transform: capitalize;" id="numero_clases" name="numero_clases" placeholder="Agrega el número de Clases" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                                        </div>

                                    </div>
                                    
                                    
                                    <label for="costo_paquete">Costo del Paquete:</label>
                                        <input type="text" id="costo_paquete" name="costo_paquete" placeholder="Agrega el costo del Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                                    <label for="vigencia_paquete">Vigencia del Paquete:</label>
                                        <input type="text" id="vigencia_paquete" name="vigencia_paquete" placeholder="Agrega la vigencia del Paquete en Días" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                                   
                                        <input type="hidden" id="invitados_paquete" value="0" name="invitados_paquete" placeholder="Agrega el Número de Invitados que puede tener el Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" maxlength="20" required>
                                   
                                        <input type="hidden" id="personas_paquete" name="personas_paquete" value="1" placeholder="Personas que están Invitadas al Paquete" class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" min="0" max="100" required>
                                    
                                    
                                    
                                    

                                ';
                            }
                            ?>
                                    <?php if (isset($_GET['id'])) : ?>
                                        <div class="d-flex justify-content-end g-2 mt-3" style="gap: 10px">
                                            <button type="button" class="btn btn-danger" onclick="eliminarPaquete(<?php echo $idPaqueteEdit; ?>)">Eliminar</button>
                                            </button>
                                            <input type="submit" value="Guardar Edición" class="btn btn-primary">
                                        </div>
                                    <?php else : ?>
                                        <div class="d-flex justify-content-center mt-3">
                                            <input type="submit" value="Agregar Paquete" class="btn btn-primary">
                                        </div>
                                    <?php endif; ?>
                               
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

    <script src="./assets/js/disciplinas.js?v=<?php echo time(); ?>"></script>
    <script src="./assets/js/paquetes.js?v=<?php echo time(); ?>"></script>

    <script>
        function mostrarVistaPrevia(event) {
            const img = document.getElementById('vistaPrevia');
            img.src = URL.createObjectURL(event.target.files[0]);
        }

document.addEventListener('DOMContentLoaded', () => {
  const dscInput = document.getElementById('dsc');
  if (dscInput) {
    dscInput.addEventListener('input', () => {
      // Eliminar cualquier carácter que no sea dígito
      let valor = dscInput.value.replace(/\D/g, '');
      // Limitar a 2 caracteres
      if (valor.length > 2) {
        valor = valor.slice(0, 2);
      }
      dscInput.value = valor;
    });
  }
});


document.addEventListener("DOMContentLoaded", function () {
  const checkSmoothie = document.getElementById("smoothie_check");
  const checkilimit = document.getElementById("ilimit_check");
  const smoothieInput = document.getElementById("smoothieInput");
  const ilimitInput = document.getElementById("ilimitInput");
  const smoothies_paquete = document.getElementById("smoothies_paquete");
  const inputNumeroClases = document.getElementById("numero_clases");

  //Guardar valor Ilimitado
  let valorActual = inputNumeroClases.value;

  //Smoothies
  if (checkSmoothie.checked) {
    smoothieInput.style.display = "block";
  }

  checkSmoothie.addEventListener("change", function () {
    if (this.checked) {
      smoothieInput.style.display = "block";
    } else {
      smoothieInput.style.display = "none";
    }
  });

smoothieInput.addEventListener("change", function () {
    console.log (smoothies_paquete)
    console.log (smoothies_paquete.value)
    if (smoothies_paquete.value > 12) {
        smoothies_paquete.style.border = "1px solid red"
    } else {
        smoothies_paquete.style.border = "none"
    }
})

    //Paquete
    if (checkilimit.checked) {
        ilimitInput.style.display = "none";
        inputNumeroClases.value = "Ilimitado";
    }

    checkilimit.addEventListener("change", function () {
        if (this.checked) {
            ilimitInput.style.display = "none";
            inputNumeroClases.value = "Ilimitado";
        } else {
            ilimitInput.style.display = "block";
            inputNumeroClases.value = valorActual === "Ilimitado" ? "" : valorActual;
        }
    });

});

function eliminarPaquete(id) {
    fetch('./eliminar-paquete.php', {
        method: 'POST',
        headers: {
            'content-type': 'application/json'
        },
        body: JSON.stringify({
            paquete: id
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Se eliminó el Paquete");
                getPaquetes();
                window.location.href = 'paquetes.php';
            } else {
                alert("Hubo un error al eliminar el Paquete");
            }
        })
        .catch(error => console.error(error));
}


function soloNumeros(inputId) {
    const input = document.getElementById(inputId);
    input.addEventListener("blur", function() {
        // Reemplaza todo lo que no sea dígito con vacío
        this.value = this.value.replace(/\D/g, "");
    });
}

// Aplica a varios inputs
soloNumeros("vigencia_paquete");
soloNumeros("costo_paquete");
</script>

</body>

</html>