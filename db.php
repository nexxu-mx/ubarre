<?php
$devON = false;
if($devON == false){
    $servername = "127.0.0.1";
    $username = "u379047759_sencia";
    $password = "Sencia25*";
    $database = "u379047759_studio";
}else{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sencia";
}

$conn = new mysqli($servername, $username, $password, $database);

?>