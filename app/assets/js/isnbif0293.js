$(document).ready(function() {
    $('#signF').on('submit', function(e) {
        e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

        // Obtener los valores de los campos de entrada
        var mail = $('#InputEmail1').val();
        var pass = $('#InputPassword1').val();

        // Enviar los datos usando AJAX
        $.ajax({
            url: './app/login.php',  // Ruta a tu archivo PHP
            type: 'POST',
            data: {
                mail: mail,
                pass: pass
            },
            success: function(response) {
                if (response === 'success') {
                    // Si la respuesta es "success", redirige a la página principal
                    window.location.href = './app/index.php';
                } else {
                    // Si la respuesta es error, muestra los errores
                    showError();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    });

    function showError() {
        // Resaltar los campos con borde rojo y borrar los valores
        $('#InputEmail1').val('').css('border', '2px solid red');
        $('#InputPassword1').val('').css('border', '2px solid red');

        // Agregar animación de sacudida (shake)
        $('#InputEmail1').add('#InputPassword1').addClass('shake');
        setTimeout(function() {
            $('#InputEmail1').add('#InputPassword1').removeClass('shake'); // Eliminar la clase después de la animación
        }, 1000); // Duración de la animación
    }
});