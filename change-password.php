<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = trim(preg_replace('/\D/', '', $_POST['numberCon'])); 
    $pass = $_POST['passw'];

    $smt = $conn->prepare("UPDATE users SET pass = ? WHERE numero = ?");
    $smt->bind_param("ss", $pass, $numero);


    if($smt->execute()){
        header("Location: login.php?change-pass=true");
        exit();

    }else{
        header("Location: login.php?change-pass=false");
        exit();
    }
}else{
    header("Location: login.php?");
    exit();
}
?>