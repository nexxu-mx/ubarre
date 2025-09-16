<?php

include '../db.php';

if (
    isset($_POST['nombre_paquete']) &&
    isset($_POST['numero_clases']) &&
    isset($_POST['costo_paquete']) &&
    isset($_POST['vigencia_paquete']) &&
    isset($_POST['invitados_paquete']) &&
    isset($_POST['personas_paquete']) &&
    isset($_POST['smoothies_paquete'])
   
) {
    $nombrePaquete = trim(strtoupper($_POST['nombre_paquete']));
    $numeroClases = trim($_POST['numero_clases']);
    $costoPaqueteSinComa = str_replace(",", "", $_POST['costo_paquete']);
    $costoPaquete = $costoPaqueteSinComa;
    $vigenciaPaquete = trim($_POST['vigencia_paquete']);
    $invitadosPaquete = trim($_POST['invitados_paquete']);
    $personasPaquete = trim($_POST['personas_paquete']);



    $smoothieCheck = isset($_POST['smoothie_check']) ? 1 : 0;
    $smoothiesPaquete = trim($_POST['smoothies_paquete']);
    $ilimitcheck = isset($_POST['ilimit_check']) ? 1: 0;

    $descuento = trim($_POST['dsc']);
    $descuento = $descuento === '' ? null : $descuento;
    if(empty($descuento)){
        $finalizadsc = null;
    }else{
    $finalizadsc = trim($_POST['vigen']);
    $finalizadsc = $finalizadsc === '' ? null : $finalizadsc;
    }

    if (isset($_POST['id_paquete_edit'])) {
        $idPaqueteEdit = $_POST['id_paquete_edit'];

        $updatePaquete = $conn->prepare("UPDATE paquetes SET clases = ?, costo = ?, nombre = ?, vigencia = ?, invitados = ?, persona = ?, descuento = ?, finalizadsc = ?, smoothies = ?, total_smoothies = ?, ilimitado = ? WHERE id = ?");
        $updatePaquete->bind_param("sssssssssisi", $numeroClases, $costoPaquete, $nombrePaquete, $vigenciaPaquete, $invitadosPaquete, $personasPaquete, $descuento, $finalizadsc, $smoothieCheck, $smoothiesPaquete, $ilimitcheck, $idPaqueteEdit); 

        $resultadoUpdatePaquete = $updatePaquete->execute();
        
        header('location: paquetes.php');
        exit;
    } else {
        $insertPaquete = $conn->prepare("INSERT INTO paquetes (clases, costo, nombre, vigencia, invitados, persona, smoothies, total_smoothies, ilimitado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertPaquete->bind_param("ssssssiss", $numeroClases, $costoPaquete, $nombrePaquete, $vigenciaPaquete, $invitadosPaquete, $personasPaquete, $smoothieCheck, $smoothiesPaquete, $ilimitcheck);

        $resultadoInsert = $insertPaquete->execute();

        header('location: paquetes.php');
        exit;
    }

    header('location: paquetes.php');
    exit;
}
