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
    $idC = $_POST['iden'];
    $nombreCoach = trim($_POST['nombre_coach']);
    $descCoach = $_POST['desc_coach'];
    $nombreDisc = trim(strtoupper($_POST['nombre_disc']));
    $activo = $_POST['activo'];
    $imagen = $_FILES['imagen'];
    $idDisciplina;
    $idCoachImage;

    // Primer select para obtener el id y el nombre de la disciplina donde el nombre sea igual al que recibimos en el form
    $select = "SELECT id, nombre_disciplina FROM disciplinas WHERE nombre_disciplina = '$nombreDisc'";

    $resultadoSelect = $conn->query($select);

    while ($filaSelect = mysqli_fetch_assoc($resultadoSelect)) {
        // Igualamos el id de la disciplina con el id de la consulta para el insert del coach
        $idDisciplina = $filaSelect['id'];
    }

    // Consulta del insert para agregar al coach en la base de datos
    $insert = "INSERT INTO coaches (nombre_coach, descripcion_coach, id_disciplina, activo) VALUES ('$nombreCoach', '$descCoach', '$idDisciplina', '$activo')";

    $resultadoInsert = $conn->query($insert);

    $insert = $conn->prepare("UPDATE coaches SET nombre_coach = ?, descripcion_coach = ?, id_disciplina = ?, activo = ? WHERE id = ?");
    if(!$insert){
        echo "error al preparar sentencia";
    }
    $insert->bind_param("ssiii", $nombreCoach, $descCoach, $idDisciplina, $activo, $idC);
    if($insert->execute()){
        $idCoachImage = $idC;
    }else{
        echo "error al update";
        exit();
    }
  
    
    // If para saber si se recibió de manera correcta la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreTemporal = $_FILES['imagen']['tmp_name'];


        // Generar un nombre único (puedes usar uniqid, time, etc.)
        $nuevoNombre = $idCoachImage . '.png';

        // Carpeta donde se guardarán las imágenes
        $carpetaDestino = '../assets/images/coaches/pro';

        $rutaDestino = $carpetaDestino . $nuevoNombre;

        if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
            echo "Todo Correcto";
        }
    } else {
        
    }


    header('location: coach.php');
    exit;
}
