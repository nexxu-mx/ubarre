<?php
// Conexión a la base de datos
include './db2.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del empleado a eliminar
$id = $_POST['id'];

// Consulta SQL para eliminar al empleado
$sql = "DELETE FROM usr WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Empleado eliminado exitosamente";
} else {
    echo "Error al eliminar el empleado: " . $conn->error;
}

$conn->close();
?>
