<?php


include '../db.php';

// Validar que se reciban los datos necesarios (imagen es OPCIONAL)
if (
    isset($_POST['nombre_coach']) &&
    isset($_POST['desc_coach']) &&
    isset($_POST['nombre_disc']) &&
    isset($_POST['activo'])
) {
    // Variables
    $idCoachUser = trim($_POST['nombre_coach']);
    $descCoach = $_POST['desc_coach'];
    $idDisciplina = $_POST['nombre_disc'];
    $activo = $_POST['activo'];

    // Validación de entrada
    if (empty($idCoachUser)) {
        header('location: alta-coach.php?error=nombre_vacio');
        exit;
    }

    $queryUser = "SELECT nombre FROM users WHERE id = ? AND (tipoUser = 2 OR tipoUser = 3);";
    $stmtUser = $conn->prepare($queryUser);
    $stmtUser->bind_param("i", $idCoachUser);

    if (!$stmtUser->execute()) {
        error_log(" Error al insertar coach: " . $stmt->error);
        header('location: alta-coach.php?error=db_error');
        exit;
    }

    $resUser = $stmtUser->get_result();
    $rowUser = $resUser->fetch_assoc();
    if (empty($rowUser) || empty($rowUser['nombre'])) {
        $nombreSelect = $rowUser['nombre'];
        // Imagen no válida, pero continuar con el registro del coach
        error_log("No se encontro ningun nombre:".$rowUser['nombre'] );
        header("location: alta-coach.php?warning=nombre_vacio_$nombreSelect");
        return;
    }
    $nombreCoach = $rowUser['nombre'];



    // USAR PREPARED STATEMENTS para prevenir SQL injection
    $stmt = $conn->prepare("INSERT INTO coaches (nombre_coach, descripcion_coach, id_disciplina, activo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nombreCoach, $descCoach, $idDisciplina, $activo);

    if ($stmt->execute()) {
        $idCoachImage = $conn->insert_id; // Obtener el ID insertado

        // actualizamos el usario asignanode uus idUser que corresponde solo para los coaches
        $queryUpdate = "UPDATE users SET iduser = ? WHERE id = ?";
        $stmt = $conn->prepare($queryUpdate);
        $stmt->bind_param("ii", $idCoachImage, $idCoachUser);
        if (!$stmt->execute()) {
            error_log(" Error al insertar coach de forma correcta, porfavor elimine y intentelo de nuevo \n Error: " . $stmt->error);
            header('location: alta-coach.php?error=db_error');
            exit;
        }

        //  Procesar imagen SOLO si se subió
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $archivoTemporal = $_FILES['imagen']['tmp_name'];
            $tipoArchivo = $_FILES['imagen']['type'];

            // Validar que sea una imagen PNG válida
            $tiposPermitidos = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                // Imagen no válida, pero continuar con el registro del coach
                error_log(" Tipo de archivo no permitido: $tipoArchivo");
                header('location: alta-coach.php?warning=imagen_no_valida');
                exit;
            }

            $nuevoNombre = $idCoachImage . '.png';
            $carpetaDestino = '../assets/images/coaches/pro/';

            // Crear directorio si no existe
            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0755, true);
            }

            $rutaDestino = $carpetaDestino . $nuevoNombre;

            // Intentar mover el archivo
            if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                // Convertir a PNG si es JPEG
                if ($tipoArchivo === 'image/jpeg' || $tipoArchivo === 'image/jpg') {
                    $imagen = imagecreatefromjpeg($rutaDestino);
                    imagepng($imagen, $rutaDestino);
                    imagedestroy($imagen);
                }
                header('location: alta-coach.php?success=coach_creado_con_imagen');
            } else {
                error_log(" Error al mover archivo de imagen");
                header('location: alta-coach.php?warning=imagen_no_guardada');
            }
        } else {
            // Coach creado sin imagen (es válido)
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Hubo error al subir
                $errorCode = $_FILES['imagen']['error'];
                error_log(" Error al subir imagen. Código: $errorCode");
                header('location: alta-coach.php?warning=error_subida_imagen');
            } else {
                // No se seleccionó imagen (válido)
                header('location: alta-coach.php?success=coach_creado_sin_imagen');
            }
        }
    } else {
        error_log(" Error al insertar coach: " . $stmt->error);
        header('location: alta-coach.php?error=db_error');
    }

    $stmt->close();
    exit;
}
