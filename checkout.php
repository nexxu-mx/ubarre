<?php
session_start();
if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}else{
    if(isset($_GET['id'])) {
        $IDpaquete = $_GET['id'];
        $_SESSION['paquete'] = $IDpaquete;
    } else {
        header("Location: paquetes.php");
        exit;  
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sencia Studio</title>
    <meta name="title" content="Sencia Studio">
    <meta name="description" content="SENCIA es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral.">
    <link rel="shortcut icon" href="./favicon.png" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>"> 
    <?php include 'head.php'; ?>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <link rel="stylesheet" href="./assets/css/profile.css?v=<?php echo time(); ?>">
    <style>
    .dsco{
      position: absolute;
      top: -10px;
      right: -14px;
      padding: 12px;
      background: #BFA187;
      font-size: 20px;
      border-radius: 50%;
      color: #fff;
      box-shadow: 0px 2px 12px #00000038;
    }
          .ver-mas-paquetes-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            }
            .elect{
                display: flex;
              flex-direction: column;
              align-content: center;
              justify-content: center;
              align-items: center;
              border: 2px solid #BFA187;
              padding: 15px;
              border-radius: 23px;
              margin: 20px;
              transition: all 0.5s ease;
            }
            .elect:hover, .elect:focus{
                background: #BFA1872E;
            }
            .card{
                position: relative;
            }
            
            
    </style>
</head>

<body id="top">
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php //include 'ofer.php'; ?> 
    <?php include 'header.php'; ?>

    
    <div style="position: fixed; z-index: -1; top: 0; left: 0; width: 100%; heigth: 100%">
        <video src="./assets/images/sencia_gradient.mp4" autoplay loop muted></video>
    </div>
    <!-- MAIN SECTION -->
    <main>
        <article>
            <section class="secti-on">
                <div class="container">
                       <div class="p1">
                        <h1 style="text-align: center;font-size: 3rem;font-weight: 400;">Comprar Paquete</h1>
                            <div class="c0" id="data-pago">
                                <div class="c1">
                                    <div class="card">
                                        <?php
                                            include 'db.php';
                                            // Obtener información del paquete
                                            $sqlP = "SELECT clases, nombre, costo, vigencia, descuento FROM paquetes WHERE id = ?";
                                            $stmtP = $conn->prepare($sqlP);
                                            $stmtP->bind_param("i", $IDpaquete);
                                            $stmtP->execute();
                                            $resultP = $stmtP->get_result();

                                            if ($resultP->num_rows === 0) {
                                                http_response_code(400);
                                                die(json_encode(['error' => 'Paquete no encontrado']));
                                            }
                                            $rowP = $resultP->fetch_assoc();
                                            if($rowP['clases'] == "ILIMITADO"){
                                                $nclases = '<p class="numero-clases-card" style="font-size: 44px; margin-block: 10px;">' . $rowP['clases'] . '</p>';
                                            }else{
                                                $nclases = '<p class="numero-clases-card">' . $rowP['clases'] . '</p>';
                                            }
                                            if(!empty($rowP['descuento'])){
                                                echo '<p class="dsco">' . $rowP['descuento'] . '%</p>';
                                                
                                                $preciods = ($rowP['costo'] / 100) * $rowP['descuento'];
                                                $costodes =  $rowP['costo'] - $preciods; 
                                                $costo = '<del style="color: #a0a0a0;">$' . number_format($rowP['costo'], 2) . '</del> 
                                                        <p class="precio-card" style="margin-top: -20px;" id="costto">MX $' . number_format($costodes, 2) . '</p>';
                                                
                                            }else{
                                                $costo = '<p class="precio-card" id="costto">MX $' . number_format($rowP['costo'], 2) . '</p>';
                                            }
                                            echo '<p class="tipo-card">' . $rowP['nombre'] . '</p>' . $nclases . '
                                                    <p class="clases-card">CLASES</p>
                                                    ' . $costo . '
                                                    <p class="vigencia-card">Vigencia ' . $rowP['vigencia'] . ' días</p>';

                                        ?>
                                       
                                    </div>
                                </div>
                                
                                <div class="c2">
                                    <div id="eleccion_pago">
                                        <a href="https://wa.me/524792179429?text=Hola,%20Quiero%20comprar%20un%20paquete." class="elect"><img src="./assets/images/shop.svg" style="width: 50px" alt="">
                                        Pagar en sitio</a>
                                        <button onclick="payTarjet()" class="elect"><img src="./assets/images/card.svg" style="width: 50px" alt="">Tarjeta Crédito/Débito</button>
                                    </div>
                                   <div id="metodo_pago" style="display: none">
                                        <input type="hidden" id="coust" name="coust" value="<?php echo $IDpaquete; ?>"/>
                                        <input type="hidden" id="idusrv" name="idusrv" value="3"/>
                                        <div id="paymentBrick_container" class="c10"></div>
                                   </div>
                                    
                                </div>
                                
                            </div>
                        
                            <div id="resque" style="display: flex;justify-content: center;"></div>
                       </div>
                </div>
            </section>
            
        </article>
    </main>



    <a href="#" class="back-top-btn" aria-label="back to top"
      data-back-top-btn styel="display: none">
      <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp">
    </a>
   
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script src="./mp3.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>