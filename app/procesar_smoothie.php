<?php
session_start();
include '../error_log.php';
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar datos
    $sabor = trim($_POST['sabor_smoothie']);
    $idSmoothieEdit = isset($_POST['id_smoothie_edit']) ? (int)$_POST['id_smoothie_edit'] : 0;
    
    // Validar que el sabor no esté vacío
    if (empty($sabor)) {
        $_SESSION['error'] = "El sabor del smoothie no puede estar vacío";
        header('location: alta-smoothie.php' . ($idSmoothieEdit ? '?id=' . $idSmoothieEdit : ''));
        exit;
    }

    if ($idSmoothieEdit == 0) {
        // Insertar nuevo smoothie
        $insertSmoothie = $conn->prepare("INSERT INTO smoothies (sabor) VALUES (?)");
        $insertSmoothie->bind_param("s", $sabor);
        
        if ($insertSmoothie->execute()) {
            $idSmoothie = $conn->insert_id;
            $_SESSION['mensaje'] = "Smoothie agregado correctamente";
        } else {
            $_SESSION['error'] = "Error al agregar el smoothie: " . $conn->error;
            header('location: alta-smoothie.php');
            exit;
        }
    } else {
        // Actualizar smoothie existente
        $idSmoothie = $idSmoothieEdit;
        $updateSmoothie = $conn->prepare("UPDATE smoothies SET sabor = ? WHERE id = ?");
        $updateSmoothie->bind_param("si", $sabor, $idSmoothie);
        
        if ($updateSmoothie->execute()) {
            $_SESSION['mensaje'] = "Smoothie actualizado correctamente";
        } else {
            $_SESSION['error'] = "Error al actualizar el smoothie: " . $conn->error;
            header('location: alta-smoothie.php?id=' . $idSmoothie);
            exit;
        }
    }

    // Procesar la imagen si se ha subido
    if (isset($_FILES['imagen-smoothie']) && $_FILES['imagen-smoothie']['error'] === UPLOAD_ERR_OK) {
        
        // Crear carpeta principal de smoothies si no existe
        $carpetaSmoothies = "../assets/images/smoothies/";
        if (!is_dir($carpetaSmoothies)) {
            if (!mkdir($carpetaSmoothies, 0777, true)) {
                $_SESSION['error'] = "Error al crear la carpeta principal para las imágenes";
                header('location: smoothies.php');
                exit;
            }
        }

        // Obtener información del archivo
        $nombreTemporal = $_FILES['imagen-smoothie']['tmp_name'];
        $nombreOriginal = $_FILES['imagen-smoothie']['name'];
        $tamañoArchivo = $_FILES['imagen-smoothie']['size'];
        
        // Validaciones de seguridad
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        
        // Verificar tipo de archivo real
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $nombreTemporal);
        finfo_close($finfo);
        
        $mimesPermitidos = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
        
        if (!in_array($extension, $extensionesPermitidas) || !in_array($mimeType, $mimesPermitidos)) {
            $_SESSION['error'] = ($_SESSION['error'] ?? "") . " Tipo de archivo no permitido. Solo se permiten imágenes JPG, JPEG, PNG, GIF y WEBP";
            header('location: alta-smoothie.php' . ($idSmoothieEdit ? '?id=' . $idSmoothieEdit : ''));
            exit;
        }
        
        // Verificar tamaño (máximo 5MB)
        if ($tamañoArchivo > 5 * 1024 * 1024) {
            $_SESSION['error'] = ($_SESSION['error'] ?? "") . " La imagen es demasiado grande. Máximo 5MB permitido";
            header('location: alta-smoothie.php' . ($idSmoothieEdit ? '?id=' . $idSmoothieEdit : ''));
            exit;
        }
        
        // Nombre del archivo: (Id) . (extensión)
        $nombreArchivo = $idSmoothie . '.' . $extension;
        $rutaDestino = $carpetaSmoothies . $nombreArchivo;
        
        // Eliminar imagen anterior si existe
        $archivosAnteriores= glob($carpetaSmoothies . $idSmoothie . '.*');
        foreach ($archivosAnteriores as $archivo) {
            if (is_file($archivo)) {
                unlink($archivo);
            }
        }
        
        // Mover archivo
        if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
            $_SESSION['mensaje'] = ($_SESSION['mensaje'] ?? "") . " Imagen subida correctamente.";
        } else {
            $_SESSION['error'] = "Error al guardar la imagen";
        }
    }
    
    header('location: smoothies.php'); 
    exit;
} else {
    $_SESSION['error'] = 'Método no permitido';
    header('location: smoothies.php');
    exit;
}