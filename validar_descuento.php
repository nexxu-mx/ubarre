<?php
header('Content-Type: application/json');
session_start();
date_default_timezone_set('America/Mexico_City');
$idusrv = $_SESSION['idUser'];

include 'db.php';


if($_SESSION['intentosDsc'] == 3){
        echo json_encode([
            "success" => false,
            "motivo" => "Excedió los intentos permitidos"
            ]);
        exit;
}
$code = $_POST['code'] ?? '';
$code = preg_replace("/[^a-zA-Z0-9]/", "", $code);
if($code){
    

    $sql = "SELECT descuento, activo, fin, excepcion FROM descuentos WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        
        $intentos = $_SESSION['intentosDsc']; 
        $intentos = $intentos + 1;

        $_SESSION['intentosDsc'] = $intentos; 
        echo json_encode([
            "success" => false,
            "intentos" =>  $_SESSION['intentosDsc']
            ]);
        exit;
    }else{
         $row = $result->fetch_assoc();
            
            if($row['activo'] == 1){
                //codigo activo
                 $hoy = date("Y-m-d");
                $vencimiento = $row['fin'];
                if ($hoy > $vencimiento) {
                    $intentos = $_SESSION['intentosDsc']; 
                    $intentos = $intentos + 1;

                    $_SESSION['intentosDsc'] = $intentos; 
                    echo json_encode([
                        "success" => false,
                        "intentos" =>  $_SESSION['intentosDsc'],
                        "motivo" => "Código expirado."
                        ]);
                    exit;
                }else{
                    // codigo activo

                    if($row['excepcion'] == 1){
                        $sqlU = ("SELECT founder FROM users WHERE id = ?");
                        $smtU = $conn->prepare($sqlU);
                        $smtU->bind_param("i", $idusrv);
                        $smtU->execute();
                        $res = $smtU->get_result();
                        if($res->num_rows > 0){
                            $rowU = $res->fetch_assoc();
                            $founder = $rowU['founder'];
                            if(empty($founder)){
                                 $_SESSION['codeD'] = $row['descuento'];
                                    $descuento = $row['descuento'];

                                    $_SESSION['intentosDsc'] = 0; 


                                echo json_encode([
                                    "success" => true,
                                    "descuento" => $descuento
                                ]);
                            }else{
                                     $intentos = $_SESSION['intentosDsc']; 
                                    $intentos = $intentos + 1;

                                    $_SESSION['intentosDsc'] = $intentos; 
                                    echo json_encode([
                                        "success" => false,
                                        "intentos" =>  $_SESSION['intentosDsc'],
                                        "motivo" => "Es fundador."
                                        ]);
                                    exit;
                            }
                                 
                        }
                    
                
                    }else{ 
                        $_SESSION['codeD'] = $row['descuento'];
                        $descuento = $row['descuento'];

                        $_SESSION['intentosDsc'] = 0; 


                        echo json_encode([
                            "success" => true,
                            "descuento" => $descuento
                        ]);
                    }
                }
               

                
            }else{
                /// codigo finalizo inactivo
                $intentos = $_SESSION['intentosDsc']; 
                $intentos = $intentos + 1;

                $_SESSION['intentosDsc'] = $intentos; 
                echo json_encode([
                    "success" => false,
                    "intentos" =>  $_SESSION['intentosDsc'],
                    "motivo" => "Código finalizado."
                    ]);
                exit;
            }
            
    }
    
   $_SESSION['intentosDsc'] = 1; 
}
?>
