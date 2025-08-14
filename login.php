<?php
session_start();
if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    $loge = "ok";
}else{
    header("Location: profile.php");
    exit();
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
    <style>
        .btn-code {
            font-size: 1;
        }
    </style>
</head>

<body id="top">
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php include 'ofer.php'; ?> 
    <?php include 'header.php'; ?>

    

    <!-- MAIN SECTION -->
    <main>
        <article>
            <section class="login-main-section">
                <div class="container" id="loginForm" >
                    <form action="loger.php" method="post" class="login-form" style="padding-top: 20px">
                        <h2>INICIA SESIÓN</h2>
                        <p class="registro-mensaje">¿Es tu primera vez? <span><button type="button" onclick="openRegistro()">Regístrate</button></span></p>
        
                        <label for="number">Número*</label>
                        <input type="text" name="number" id="number" placeholder="477 123 4567" maxlength="10" minlength="9" required>
                        <label for="contras" id="labelNum" style="display: none">Contraseña</label>
                        <div style="display: none" id="contentNum">
                            <input type="password" name="contras" id="contras" placeholder="********" maxlength="30" minlength="5" required>
                            
                        </div>
        
                        <button type="button" class="olv-contra" onclick="openCo()">Olvide mi contraseña.</button>
        
                        <input class="login-submit-btn" type="submit" id="log" value="INICIAR SESIÓN">
                    </form> 
                </div>
                <div class="container" id="registro" style="margin-block: 20px; display: none">
                    <form action="registro.php" method="post" class="login-form">
                        <img src="assets/images/svg/logo-negro.svg" alt="Logo Sencia">
                        <h2>VAMOS A REGISTRARTE</h2>
                        <p class="registro-mensaje">¿Ya tienes cuenta? <span><button type="button" onclick="closeRegistro()">Iniciar Sesión</button></span></p>
                        <label for="nombreR">Nombre*</label>
                        <input type="text" name="nombreR" id="nombreR" placeholder="Adriana Alba" maxlength="100" minlength="5" required>
                        <label for="mailR">Correo Electrónico*</label>
                        <input type="email" name="mailR" id="mailR" placeholder="tuemail@mail.com" maxlength="100" minlength="5" required>
                        <label for="numeroR">WhatsApp*</label>
                        <input type="text" name="numeroR" id="numeroR" placeholder="477 123 4567" maxlength="10" minlength="9" required>
                        <label for="contra">Contraseña*</label>
                        <input type="password" name="contra" id="contra" placeholder="********" maxlength="30" minlength="5" required>
                        <small>La contraseña debe tener mínimo 5 caracteres.</small>
                        <label for="date">Fecha de Nacimiento*</label>
                        <div class="inputs-reserva-container">
                        <select name="dia" id="dia">
                        </select>
                        <select name="mes" id="mes">
                        </select>
                        <select name="anio" id="anio">
                        </select>
                        </div>

                        <label for="invit">Tengo un Código de Invitación</label>
                        <input type="text" name="invit" id="invir" placeholder="XT2L93" maxlength="6" minlength="5">

                        <div style="display: flex; align-items: center; gap: 5px">
                            <input type="checkbox" style="width: 20px" required>
                            <small>Acepto los Términos y Condiciones</small>
                        </div>
                            <button class="login-submit-btn" type="submit" id="registrarse" disabled>REGISTRARME</button>
                    </form>
                </div>
                <div class="container" id="contraseña" style="margin-block: 20px; display: none">
                    <form action="change-password.php" method="post" class="login-form"  style="padding-block: 20px;">
                        <button type="button" onclick="closeCo()">Regresar</button>
                        
                        <label for="numberCon">Número*</label>
                        <input type="text" name="numberCon" id="numberCon" placeholder="477 123 4567" maxlength="10" minlength="9" required>
                        <small>Ingresa tu número, y espera el código de validación para cambiar tu contraseña.</small>
                          <input type="hidden" name="recuperar" id="recuperar" value="1" required>
                        <label for="code" id="labelCon" style="display: none">Código de Validación</label>
                        <div style="display: none" id="contentCon">
                            <input type="text" name="code" id="code" placeholder="000 000" maxlength="6" minlength="5" required>
                            <button type="button" class="login-submit-btn btn-code" id="btn-code"><ion-icon name="reload-outline" aria-hidden="true"></ion-icon></button>
                        </div>
                        <div id="passd" style="text-align: initial;"></div>
                       
                        <button class="login-submit-btn" type="submit" id="changecontra" disabled>Cambiar contraseña</button>
                    </form>
                </div>
                
            </section>
            
        </article>
    </main>

    <?php include 'footer.php'; ?>
    <a href="https://wa.me/524792179429?text=Hola,%Quiero%20más%20información%20de%20SENCIA." class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <img src="assets/images/svg/whats.svg" alt="Ícono WhatsApp">
    </a>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        document.getElementById("number").addEventListener("input", async function() {
            let input = this.value.replace(/\D/g, ''); 
            input = input.substring(0, 10); 
            this.value = input;

            if (input.length === 10) {
                const response = await fetch("validate_number.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "numero=" + encodeURIComponent(input)
                });

                const result = await response.json();

                if (result.exists) {
                    this.style.border = "1px solid green";
                    document.getElementById("labelNum").style.display = "block";
                    document.getElementById("contentNum").style.display = "flex";
                } else {
                    this.style.border = "2px solid red";
                    document.getElementById("labelNum").style.display = "none";
                    document.getElementById("contentNum").style.display = "none";
                }
            } else {
                this.style.border = ""; // Reset
                document.getElementById("labelNum").style.display = "none";
                document.getElementById("contentNum").style.display = "none";
            }
        });
        //olvide mi contraseña
        document.getElementById("numberCon").addEventListener("input", async function() {
    let input = this.value.replace(/\D/g, ''); 
    input = input.substring(0, 10); 
    this.value = input;

    if (input.length === 10) {
        var recuperar = document.getElementById('recuperar').value;
        const response = await fetch("validate_number.php?", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "numero=" + encodeURIComponent(input) + "&recuperar=" + encodeURIComponent(recuperar)
        });

        const result = await response.json();

        if (result.exists) {
            this.style.border = "1px solid green";
            document.getElementById("labelCon").style.display = "block";
            document.getElementById("contentCon").style.display = "flex";

            const btnCode = document.getElementById("btn-code");
            let seconds = 60;

            btnCode.disabled = true;
            btnCode.innerText = `${seconds}s`;

            const interval = setInterval(() => {
                seconds--;
                btnCode.innerText = `${seconds}s`;

                if (seconds <= 0) {
                    clearInterval(interval);
                    btnCode.disabled = false;
                    btnCode.innerHTML = `<ion-icon name="reload-outline" style="font-size: 18px;" aria-hidden="true"></ion-icon>`;
                }
            }, 1000);
        } else {
            this.style.border = "2px solid red";
            document.getElementById("labelCon").style.display = "none";
            document.getElementById("contentCon").style.display = "none";
        }
    } else {
        this.style.border = ""; // Reset
        document.getElementById("labelCon").style.display = "none";
        document.getElementById("contentCon").style.display = "none";
    }
});

        //omc fin
        function cargarOpcionesFecha() {
        const selectDia = document.getElementById("dia");
        const selectMes = document.getElementById("mes");
        const selectAnio = document.getElementById("anio");

        // Días (01 a 31)
        for (let d = 1; d <= 31; d++) {
            const valor = d.toString().padStart(2, "0");
            selectDia.innerHTML += `<option value="${valor}">${valor}</option>`;
        }

        // Meses (01 a 12)
        const meses = [
            { nombre: "Ene", valor: "01" },
            { nombre: "Feb", valor: "02" },
            { nombre: "Mar", valor: "03" },
            { nombre: "Abr", valor: "04" },
            { nombre: "May", valor: "05" },
            { nombre: "Jun", valor: "06" },
            { nombre: "Jul", valor: "07" },
            { nombre: "Ago", valor: "08" },
            { nombre: "Sep", valor: "09" },
            { nombre: "Oct", valor: "10" },
            { nombre: "Nov", valor: "11" },
            { nombre: "Dic", valor: "12" }
        ];

        meses.forEach(m => {
            selectMes.innerHTML += `<option value="${m.valor}">${m.nombre}</option>`;
        });

        // Años (de 1920 a año actual)
        const añoActual = new Date().getFullYear();
        for (let y = añoActual; y >= 1920; y--) {
            selectAnio.innerHTML += `<option value="${y}">${y}</option>`;
        }
    }
    document.getElementById("nombreR").addEventListener("blur", function() {
        let nombre = this.value.trim(); 
        nombre = nombre.toLowerCase(); 
        nombre = nombre.replace(/\b\w/g, function(l) { return l.toUpperCase(); }); 
        this.value = nombre;
    });
    document.getElementById("code").addEventListener("input", async function () {
        const code = this.value.replace(/\D/g, '').substring(0, 6); // Solo 6 números
        this.value = code;

        if (code.length === 6) {
            const number = document.getElementById("numberCon").value;

            const response = await fetch("validate_code.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "numero=" + encodeURIComponent(number) + "&code=" + encodeURIComponent(code)
            });

            const result = await response.json();

            const logButton = document.getElementById("changecontra");
            if (result.valid) {
                logButton.disabled = false;
                document.getElementById("code").style.border = "1px solid green";
                document.getElementById("passd").innerHTML = '  <label for="passw">Nueva contraseña</label><input type="text" name="passw" id="passw" placeholder="********" maxlength="30" minlength="5" required>';
            } else {
                logButton.disabled = true;
                document.getElementById("code").style.border = "1px solid red";
            }
        }
    });
    document.getElementById("contras").addEventListener("input", async function () {
        const code = this.value;

        if (code) {
            const number = document.getElementById("number").value;

            const response = await fetch("validate_contra.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "numero=" + encodeURIComponent(number) + "&contra=" + encodeURIComponent(code)
            });

            const result = await response.json();

            const logButton = document.getElementById("log");
            if (result.valid) {
                logButton.disabled = false;
                document.getElementById("contras").style.border = "1px solid green";
            } else {
                logButton.disabled = true;
                document.getElementById("contras").style.border = "1px solid red";
            }
        }
    });

    document.getElementById("numeroR").addEventListener("input", async function() {
        let input = this.value.replace(/\D/g, '');
        input = input.substring(0, 10);
        this.value = input;

        const registrarseBtn = document.getElementById("registrarse");

        if (input.length === 10) {
            const response = await fetch("validate_number_regis.php", { 
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "numero=" + encodeURIComponent(input)
            });

            const result = await response.json();
            if (result.exists) {
                this.style.border = "2px solid red";
                registrarseBtn.disabled = true;
            } else {
                this.style.border = "2px solid green";
                registrarseBtn.disabled = false;
            }
        } else {
            this.style.border = "";
            registrarseBtn.disabled = true;
        }
    });
    document.getElementById("mailR").addEventListener("input", async function() {
        let email = this.value.trim();
        const registrarseBtn = document.getElementById("registrarse");

        if (email.length > 5) { 
            const response = await fetch("validate_email_register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "email=" + encodeURIComponent(email)
            });

            const result = await response.json();

            if (result.exists) {
                this.style.border = "2px solid red";
                registrarseBtn.disabled = true;
            } else {
                this.style.border = "2px solid green";
                registrarseBtn.disabled = false;
            }
        } else {
            this.style.border = "";
            registrarseBtn.disabled = true;
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        cargarOpcionesFecha();
    });
    </script>

</body>

</html>