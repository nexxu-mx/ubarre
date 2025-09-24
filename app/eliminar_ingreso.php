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
$sql = "DELETE FROM ing WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "ingreso eliminado exitosamente";
} else {
    echo "Error al eliminar el ingreso: " . $conn->error;
}

$conn->close();
?>
