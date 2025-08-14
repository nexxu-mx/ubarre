<?php

date_default_timezone_set('America/Mexico_City');
$ingreso = "1745514278";
$timestamp = time();
echo $timestamp;

session_start();
echo "<br>";
if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    echo "no logeado";
} else {
    echo "logeado como: " . $_SESSION['nombre'];
}

?>