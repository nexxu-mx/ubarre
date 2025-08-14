

$(document).ready(function() {
    // Inicializar DataTable con la opción de orden descendente en la primera columna
    let tabla = $('#basic-datatables').DataTable({
        "order": [[0, 'desc']]  // Ordenar por la primera columna (índice 0) en orden descendente
    });

    // Función para cargar los productos en la tabla
    function cargarProductos() {
        $.ajax({
            url: 'transac.php',  // URL donde se obtiene el JSON
            type: 'GET',
            dataType: 'json',  // Esperamos una respuesta en JSON
            success: function(data) {
                // Limpiar el contenido actual de la tabla
                tabla.clear().draw();

                // Insertar filas dinámicamente con los datos obtenidos
                data.forEach(function(producto) {
                    // Agregar una fila a la tabla con los datos de cada producto
                    tabla.row.add([
                        producto.idpago,
                        producto.cliente,
                        "$ " + producto.monto + " (" + producto.recibido + ")",
                        producto.creditos,
                        producto.metodo,
                        producto.fecha

                        
                    ]).draw();
                });
            },
            error: function() {
                alert('Error al cargar los productos');
            }
        });
    }

    // Cargar productos cuando se cargue la página
    cargarProductos();

    // Hacer la solicitud AJAX al archivo PHP
    $.ajax({
        url: 'balance.php', // El archivo PHP que devuelve los datos en formato JSON
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Procesar los datos recibidos
            document.getElementById('uti').textContent = `$${data.utilidades.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('eg').textContent = `$${data.egresos.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('ing').textContent = `$${data.ingresos.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

        
            // Gráfico Pie (Balance)
            var pieChart = $('#pieChart')[0].getContext('2d');
            new Chart(pieChart, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [data.ingresos, data.egresos, data.utilidades],
                        backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
                        borderWidth: 0
                    }],
                    labels: ['Ingresos', 'Egresos', 'Utilidad']
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            fontColor: 'rgb(154, 154, 154)',
                            fontSize: 11,
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    pieceLabel: {
                        render: 'percentage',
                        fontColor: 'white',
                        fontSize: 14,
                    },
                    tooltips: false,
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 20,
                            bottom: 20
                        }
                    }
                }
            });

            // Gráfico de líneas (Ventas históricas)
            var ventasTienda = [];
            var ventasEcommerce = [];
            var meses = [];

            data.ventasHistoricas.forEach(function (venta) {
                meses.push(venta.mes);
                if (venta.metodo == "1") {
                    ventasTienda.push(venta.total_ventas);
                    ventasEcommerce.push(0);
                } else if (venta.metodo == "3") {
                    ventasTienda.push(0);
                    ventasEcommerce.push(venta.total_ventas);
                }
            });

            var multipleLineChart = $('#multipleLineChart')[0].getContext('2d');
            new Chart(multipleLineChart, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: "Físico",
                        borderColor: "#59d05d",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#59d05d",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        fill: true,
                        borderWidth: 2,
                        data: ventasTienda
                    }, {
                        label: "App",
                        borderColor: "#f3545d",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#f3545d",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        fill: true,
                        borderWidth: 2,
                        data: ventasEcommerce
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10
                    },
                    layout: {
                        padding: { left: 15, right: 15, top: 15, bottom: 15 }
                    }
                }
            });

            // Insertar las operaciones en la tabla
            data.operaciones.forEach(function (op) {
                var row = `<tr><td>${op.tipo}</td><td>$${op.monto.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
<td>${op.fecha}</td></tr>`;
                $('#operaciones').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener los datos:", error);
        }
    });
});


function formatearPrecio(input) {
    let valor = parseFloat(input.value);
    if (!isNaN(valor)) {
        input.value = valor.toFixed(2); // Formatea a 2 decimales
    } else {
        input.value = ''; // Limpia el campo si no es un núme ro válido
    }
}

function convertirAMayusculas(input) {
    input.value = input.value.toUpperCase();
}

const inputPrecio = document.getElementById('monto');
const inputConcepto = document.getElementById('concepto');
const inputTipo = document.getElementById('tipo');

inputPrecio.addEventListener('blur', function() {
    formatearPrecio(this);
});
inputConcepto.addEventListener('blur', function() {
    convertirAMayusculas(this);
});
inputTipo.addEventListener('blur', function() {
    convertirAMayusculas(this);
});

// Función para obtener el nombre del mes
function obtenerNombreMes(fecha) {
    const opciones = { year: 'numeric', month: 'long' }; // Configuración para obtener el mes completo
    return fecha.toLocaleDateString('es-ES', opciones); // Ejemplo: "noviembre 2024"
}

// Función para cargar la lista de egresos con el filtro de fecha
function cargarEgresos(filtroFecha = '') {
    $.ajax({
        url: 'listar_egresos.php',
        type: 'GET',
        data: { fecha: filtroFecha }, // Enviar el filtro de fecha
        success: function(response) {
            const egresos = JSON.parse(response);
            const lisemp = $('#liseg');
            lisemp.empty(); // Limpiar la lista antes de cargar los nuevos datos

            egresos.forEach(function (egreso) {
                const egresoHTML = `
                    <tr class="imsnhd" data-id="${egreso.id}">
                        <td>${egreso.fecha}</td>
                        <td>${egreso.concepto}</td>
                        <td>${egreso.tipo}</td>
                        <td>${egreso.monto}</td>
                        <td><button class="btn btn-icon btn-link btn-danger op-8 eliminar-btn">
                            <i class="fas fa-ban"></i>
                        </button></td>
                    </tr>
                `;
                lisemp.append(egresoHTML);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar egresos: ", error);
        }
    });
}

// Función para obtener la fecha del mes pasado, hace dos meses, etc.
function obtenerFechaFiltro(opcion) {
    const fechaHoy = new Date();
    let fechaFiltro = new Date();

    switch(opcion) {
        case '1m':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 1); // Mes pasado
            break;
        case '2m':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 2); // Hace dos meses
            break;
        case '3m':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 3); // Hace tres meses
            break;
        default:
            fechaFiltro = fechaHoy; // Por defecto, es el mes actual
    }

    // Formato yyyy-mm
    const anio = fechaFiltro.getFullYear();
    const mes = ('0' + (fechaFiltro.getMonth() + 1)).slice(-2); // Para asegurar que el mes sea de dos dígitos
    return `${anio}-${mes}`;
}

$(document).ready(function() {
    // Cargar los egresos del mes actual por defecto
    cargarEgresos(obtenerFechaFiltro(''));

    // Mostrar el mes actual en el título
    $('#tituloMes').text(`Egresos de ${obtenerNombreMes(new Date())}`); // Mostrar "Egresos de Noviembre" (mes actual)

    // Filtrar por fecha seleccionada en el dropdown
    $('.dropdown-item').on('click', function() {
        const opcion = $(this).attr('id');
        const fechaFiltro = obtenerFechaFiltro(opcion);
        cargarEgresos(fechaFiltro); // Recargar los egresos con el filtro aplicado

        // Actualizar el título del mes
        const nombreMes = {
            '': obtenerNombreMes(new Date()), // Mes actual
            '1m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 1))), // Mes pasado
            '2m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 2))), // Hace dos meses
            '3m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 3)))  // Hace tres meses
        };

        $('#tituloMes').text(`Egresos de ${nombreMes[opcion]}`); // Actualiza el título con el nombre del mes
    });

    // Eliminar un egreso al hacer clic en el botón de eliminar
    $('#liseg').on('click', '.eliminar-btn', function () {
        const egresoId = $(this).closest('.imsnhd').data('id');
        console.log(egresoId); 

        // Confirmar la eliminación con SweetAlert 1.x
        swal({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción.",
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Cancelar',
                    value: null,
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                },
                confirm: {
                    text: '¡Sí, eliminar!',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            }
        }).then((result) => {
            if (result) {
                // Enviar solicitud para eliminar el egreso
                $.ajax({
                    url: 'eliminar_egreso.php',
                    type: 'POST',
                    data: { id: egresoId },
                    success: function(response) {
                        swal("Eliminado!", "El egreso ha sido eliminado.", "success");
                        cargarEgresos(); // Recargar la lista de egresos
                    },
                    error: function(xhr, status, error) {
                        swal("Error!", "Hubo un problema al eliminar al egreso.", "error");
                    }
                });
            }
        });
    });

    // Manejo del formulario de registro
    $('#egreForm').on('submit', function (e) {
        e.preventDefault(); // Prevenir el envío del formulario tradicional

        // Recolectar los datos del formulario
        const formData = {
            fecha: $('#fecha').val(),
            concepto: $('#concepto').val(),
            tipo: $('#tipo').val(),
            monto: $('#monto').val()
        };

        // Enviar los datos con AJAX a un archivo PHP
        $.ajax({
            url: 'nuevo_egreso.php',  // Ruta de tu archivo PHP
            type: 'POST',
            data: JSON.stringify(formData),  // Enviar los datos como JSON
            contentType: 'application/json',
            success: function(response) {

                $('#fecha').val('');
                $('#concepto').val('');
                $('#tipo').val('');
                $('#monto').val('');

                console.log(response);
                cargarEgresos(); // Recargar la lista de egresos
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al registrar el usuario');
                console.error(error);
            }
        });
    });
});
