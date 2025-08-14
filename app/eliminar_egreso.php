<?php
// Conexión a la base de datos
include '../db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del empleado a eliminar
$id = $_POST['id'];

// Consulta SQL para eliminar al empleado
$sql = "DELETE FROM egr WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Egreso eliminado exitosamente";
} else {
    echo "Error al eliminar el Egreso: " . $conn->error;
}

$conn->close();
?>
