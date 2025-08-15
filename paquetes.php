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
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/estilos_ubarre.css?v=<?php echo time(); ?>">
  <?php include 'head.php'; ?>
  <style>
    .card {
      height: 400px;
      padding: 50px 70px;
      position: relative;
    }
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
  </style>
</head>

<body id="top">
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>

  <?php include 'ofer.php'; ?>
  <?php include 'header.php'; ?>

  <main class="main-paquetes">
    <article>
      <section class="main-section-paquetes section">
        <div class="container">
          <h1>NUESTROS <span>Paquetes</span></h1>
          <div class="inputs-container">
            <div class="buscar-input-container">
              <input type="text" placeholder="BUSCAR">
              <img src="assets/images/svg/search.svg" alt="search icon">
            </div>
            <select name="clases" id="clases-input">
              <option value="" selected>POR CLASES</option>
              <?php
              include 'db.php';
              $sql = "SELECT clases, nombre FROM paquetes";
              $result = $conn->query($sql);
              $clases = "";
              $nombr = "";
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $clases .= '<option value="' . $row['clases'] . '" >' . $row['clases'] . '</option>';
                  $nombr .= '<option value="' . $row['nombre'] . '" >' . $row['nombre'] . '</option>';
                }
                
              }
              echo $clases;
              $conn->close();
              ?>
            </select>
            <select name="disciplina" id="disciplina-input">
              <option value="" selected>POR PAQUETE</option>
              <?php echo $nombr; ?>
            </select>
          </div>
          <section class="section membresias-section membresias-paquetes">
            <div class="container">
              <div class="cards-container">

              </div>
            </div>
          </section>
        </div>
      </section>
    </article>
  </main>
  <?php include 'footer.php'; ?>
  <a href="https://wa.me/524792179429?text=Hola,%Quiero%20más%20información%20de%20SENCIA." class="back-top-btn" aria-label="back to top"
    data-back-top-btn>
    <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp">
  </a>
  <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
  <script type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include 'script.php'; ?>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const cardsContainer = document.querySelector(".cards-container");
      const searchInput = document.querySelector(".buscar-input-container input");
      const clasesInput = document.querySelector("#clases-input");
      const disciplinaInput = document.querySelector("#disciplina-input");

      function generarToken(longitud = 132) {
        const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let token = '';
        for (let i = 0; i < longitud; i++) {
          token += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }
        return token;
      }

      const fetchPaquetes = () => {
        const params = new URLSearchParams({
          search: searchInput.value.trim(),
          clases: clasesInput.value,
          disciplina: disciplinaInput.value
        });

        fetch(`get_paquetes.php?${params.toString()}`)
          .then(res => res.json())
          .then(data => {
            cardsContainer.innerHTML = "";
            if (data.length === 0) {
              cardsContainer.innerHTML = "<p>No se encontraron paquetes.</p>";
              return;
            }

            data.forEach(p => {
              const card = document.createElement("div");
              card.className = "card";

              const token = generarToken();
            function descripcionPersona(p) {
                  if (p.persona == 1) {
                      return 'Individual';
                  } else if (p.persona == 2) {
                    return '2 Personas';
                  } else if (p.persona == 4) {
                    return '4 Personas';
                  }
                  return '';
                }
                let descuento = "";
                let precio = `<p class="precio-card">MX $${p.costo}</p>`;
                
                if (typeof p.descuento !== 'undefined' && p.descuento !== null) {
                    descuento =  '<p class="dsco">' + p.descuento + '%</p>';
                    dell = '<del style="color: #a0a0a0;">$' + p.costo + '</del>';
                    
                   const costodesc = (p.costo / 100) * p.descuento;
                   const costonvo = (p.costo - costodesc).toFixed(2);
                   precio = dell + '<p class="precio-card" style="margin-top: -20px;">MX $' + costonvo + '</p>';
                    
                }
                

              card.innerHTML = `
                                <p class="tipo-card">${p.nombre}</p>
                                <p class="numero-clases-card" style="
                                  ${(p.clases == 'ILIMITADO') ? 'font-size: 4rem; margin-block: 10px' : ''}
                                ">${p.clases}</p>
                                <p class="clases-card">CLASES</p>
                                ${descuento}
                                ${precio}
                                <p style="font-size: 1.5rem;line-height: 1;color: #7a7a7a;">${descripcionPersona(p)}</p>
                                <p class="vigencia-card" style="margin-top: 0">Vigencia ${
                                  p.vigencia === 365 
                                    ? 'Anual' 
                                    : p.vigencia > 30 
                                      ? Math.round(p.vigencia / 30) + ' meses' 
                                      : p.vigencia + ' días'
                                }</p>
                                
                                
                                <a href="checkout.php?tkn=${token}&id=${p.id}">COMPRAR</a>
                            `;
              cardsContainer.appendChild(card);
            });

          });
      };

      searchInput.addEventListener("input", () => {
        setTimeout(fetchPaquetes, 300);
      });
      clasesInput.addEventListener("change", fetchPaquetes);
      disciplinaInput.addEventListener("change", fetchPaquetes);

      fetchPaquetes();
    });
  </script>

</body>

</html>