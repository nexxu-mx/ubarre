<?php
$devON = false;
if ($devON == false) {
    $servername = "127.0.0.1";
    $username = "u379047759_ubarrelem";
    $password = "Ubarre25?";
    $database = "u379047759_ubarretea";
} else {
    $servername = "82.197.82.15";
    $username = "u379047759_ubarreN";
    $password = "Ubarre2025*";
    $database = "u379047759_ubarre";
    /* $servername = "db";
    $username = "root";
    $password = "root";
    $database = "ubarre"; */
}

$conn = new mysqli($servername, $username, $password, $database);
