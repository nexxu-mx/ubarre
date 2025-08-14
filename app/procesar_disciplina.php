<?php

include '../error_log.php';

include '../db.php';


ini_set('upload_max_filesize', '64M');
ini_set('post_max_size', '64M');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombreDisc = trim(strtoupper($_POST['nombre_disc']));
    $descDisc = $_POST['desc_disc'];
    $palabraDesc1 = trim($_POST['palabra-desc-1']);
    $palabraDesc2 = trim($_POST['palabra-desc-2']);
    $palabraDesc3 = trim($_POST['palabra-desc-3']);
    $nombreCoach = trim(ucfirst($_POST['nombre_coach']));
    $idCoach;
    $idDisciplinaImage;
    $activo;

    $selectCoach = $conn->prepare("SELECT id, nombre_coach, activo FROM coaches WHERE nombre_coach = ?");
    $selectCoach->bind_param("i", $nombreCoach);
    $selectCoach->execute();
    $resultadoSelectCoach = $selectCoach->get_result();

    $filaSelectCoach = $resultadoSelectCoach->fetch_assoc();

    $idCoach = $filaSelectCoach['id'];
    $activo = $filaSelectCoach['activo'];

    echo "Id del coach sacado: " . $idCoach;

    if ($_POST['id_disciplina_edit'] == 0) {
        $insertDisciplina = $conn->prepare("INSERT INTO disciplinas (nombre_disciplina, descripcion_disciplina, subdescripcion_texto1, subdescripcion_texto2, subdescripcion_texto3, id_coach, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertDisciplina->bind_param("sssssii", $nombreDisc, $descDisc, $palabraDesc1, $palabraDesc2, $palabraDesc3, $idCoach, $activo);
        $insertDisciplina->execute();

        echo "Dentro del else de insertar disciplina";


       
        
    } else {
        $idDisciplinaEdit = $_POST['id_disciplina_edit'];

        $updateDisciplina = $conn->prepare("UPDATE disciplinas SET nombre_disciplina = ?, descripcion_disciplina = ?, subdescripcion_texto1 = ?, subdescripcion_texto2 = ?, subdescripcion_texto3 = ?, id_coach = ?, activo = ? WHERE id = ?");
        $updateDisciplina->bind_param("sssssiii", $nombreDisc, $descDisc, $palabraDesc1, $palabraDesc2, $palabraDesc3, $idCoach, $activo, $idDisciplinaEdit);
        $updateDisciplina->execute();

        /* header("location: diciplinas.php"); */
  
    
    }

    $selectDisciplina = $conn->prepare("SELECT id, nombre_disciplina FROM disciplinas WHERE nombre_disciplina = ?");
    $selectDisciplina->bind_param("s", $nombreDisc);
    $selectDisciplina->execute();
    $resultadoSelectDisciplina = $selectDisciplina->get_result();

    $filaSelectDisciplina = $resultadoSelectDisciplina->fetch_assoc();

    $idDisciplinaImage = $filaSelectDisciplina['id'] . ".mp4";

    if (isset($_FILES['imagen-disciplina']) && $_FILES['imagen-disciplina']['error'] === UPLOAD_ERR_OK) {
  
        $nombreTemporal = $_FILES['imagen-disciplina']['tmp_name'];
        // Obtener la extensión y verificar que sea .mp4
        $extension = strtolower(pathinfo($_FILES['imagen-disciplina']['name'], PATHINFO_EXTENSION));
        if ($extension !== 'mp4') {
            die("Error: Solo se permiten archivos .mp4");
        }
    
        // Carpeta destino
        $carpetaDestino = '../assets/images/disciplinas/';
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }
    
        // Nombre final del archivo: ID + .mp4
        $nombreArchivo = $filaSelectDisciplina['id'] . '.mp4';
        $rutaDestino = $carpetaDestino . $nombreArchivo;
    
        // Mover archivo
        if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
            echo "Video .mp4 subido correctamente.";
        } else {
            echo "Error al guardar el archivo.";
        }
    }
    

    


     header('location: diciplinas.php'); 
    exit;
} else {
    echo 'Error';
   
    
}
