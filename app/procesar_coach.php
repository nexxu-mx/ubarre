<?php

include '../error-log.php';

include '../db.php';

if (
    isset($_POST['nombre_coach']) &&
    isset($_POST['desc_coach']) &&
    isset($_POST['nombre_disc']) &&
    isset($_POST['activo']) &&
    isset($_FILES['imagen'])
) {
    echo 'Entra al if principal';
    // Variables
    $nombreCoach = trim($_POST['nombre_coach']);
    $descCoach = $_POST['desc_coach'];
    $idDisciplina = $_POST['nombre_disc'];
    $activo = $_POST['activo'];
    $imagen = $_FILES['imagen'];
 
    $idCoachImage;

    // Consulta del insert para agregar al coach en la base de datos
    $insert = "INSERT INTO coaches (nombre_coach, descripcion_coach, id_disciplina, activo) VALUES ('$nombreCoach', '$descCoach', '$idDisciplina', '$activo')";

    $resultadoInsert = $conn->query($insert);

    // select para obtener el id y el nombre del coach donde el nombre del coach sea igual al que recibimos
    $selectCoach = "SELECT id, nombre_coach FROM coaches WHERE nombre_coach = '$nombreCoach'";

    $resultadoSelectCoach = $conn->query($selectCoach);

    while ($filaSelectCoach = mysqli_fetch_assoc($resultadoSelectCoach)) {
        // Igualamos el id de la imagen del coach con el id del coach que acabamos de agregar para el nombre de la imagen
        $idCoachImage = $filaSelectCoach['id'];
    }

    // If para saber si se recibió de manera correcta la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreTemporal = $_FILES['imagen']['tmp_name'];

        $nuevoNombre = $idCoachImage . '.png';

        // Carpeta donde se guardarán las imágenes
        $carpetaDestino = '../assets/images/coaches/pro/';

        $rutaDestino = $carpetaDestino . $nuevoNombre;

        if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
            echo "Todo Correcto";
        }
    } else {
        
    }


    header('location: alta-coach.php');
    exit;
}
