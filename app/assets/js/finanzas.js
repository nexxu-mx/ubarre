let periodo
$(document).ready(function() {
    // Inicializar DataTable con la opción de orden descendente en la primera columna
    let tabla = $('#basic-datatables').DataTable({
        "order": [],  // Ordenar por la primera columna (índice 0) en orden descendente
        "columns": [
            { "title": "ID Pago" },
            { "title": "Cliente" },
            { "title": "Monto (Recibido)" },
            { "title": "Créditos" },
            { "title": "Método" },
            { "title": "Fecha" },
            { "title": "Acciones", "orderable": false }  // Nueva columna para acciones
        ]
    });

    // Función para eliminar una transacción
    function eliminarTransaccion(idPago) {
        if (confirm('¿Estás seguro de que deseas eliminar esta transacción? Restará los créditos correspondientes y esta acción no se puede revertir.')) {
            $.ajax({
                url: 'eliminar_transaccion.php',  // Archivo PHP para eliminar la transacción
                type: 'POST',
                data: { 
                    idpago: idPago 
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Transacción eliminada correctamente');
                        cargarProductos(); // Recargar la tabla
                        cargarBalance(obtenerFechaFiltro(''));
                    } else {
                        alert('Error al eliminar la transacción: ' + (response.message || 'Error desconocido'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error al eliminar la transacción: ' + error);
                    console.error('Error:', xhr.responseText);
                }
            });
        }
    }

    // Función para cargar los productos en la tabla
    function cargarProductos() {
        $.ajax({
            url: 'transac.php',  // URL donde se obtiene el JSON
            type: 'GET',
            dataType: 'json',  // Esperamos una respuesta en JSON
            success: function(data) {
                // Limpiar el contenido actual de la tabla
                tabla.clear();

                // Insertar filas dinámicamente con los datos obtenidos
                data.forEach(function(producto) {
                    // Verificar que el producto tenga todas las propiedades necesarias
                    if (producto && producto.idpago !== undefined && producto.cliente !== undefined && 
                        producto.monto !== undefined && producto.recibido !== undefined && 
                        producto.creditos !== undefined && producto.metodo !== undefined && 
                        producto.fecha !== undefined) {
                        
                        // Crear botón de eliminar
                        var botonEliminar = `<button class="btn eliminar-btn" style="color: red; font-size: 1.4rem;"
                                           data-idpago="${producto.id}" 
                                           title="Cancelar transacción">
                                           <i class="icon-ban"></i>
                                         </button>`;
                        
                        // Agregar una fila a la tabla con los datos de cada producto
                        tabla.row.add([
                            producto.idpago,
                            producto.cliente,
                            "$ " + producto.monto + " (" + producto.recibido + ")",
                            producto.creditos,
                            producto.metodo,
                            producto.fecha,
                            botonEliminar  // Nueva columna con botón de eliminar
                        ]);
                    }
                });
                
                // Dibujar la tabla una vez que todas las filas han sido agregadas
                tabla.draw();
            },
            error: function() {
                alert('Error al cargar los productos');
            }
        });
    }

    // Event listener para los botones de eliminar (usando delegación de eventos)
    $(document).on('click', '.eliminar-btn', function(e) {
        e.preventDefault();
        var idPago = $(this).data('idpago');
        eliminarTransaccion(idPago);
    });

    // Cargar productos cuando se cargue la página
    cargarProductos();
    cargarBalance(obtenerFechaFiltro(''));
  
    
    // Hacer la solicitud AJAX al archivo PHP para el balance
   
});
function cargarBalance(filtro) {
   
    const url = `balance.php?mes=${filtro}`;
     $.ajax({
        url: url, // El archivo PHP que devuelve los datos en formato JSON
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Procesar los datos recibidos
            document.getElementById('uti').textContent = `$${data.utilidades.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('eg').textContent = `$${data.egresos.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('ing').textContent = `$${data.ingresos.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('ocupacion').textContent = `${data.ocupacion.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}%`;

        
            // Gráfico Pie (Balance)
            document.getElementById('pieChart').innerHTML = '';
            var pieChart = $('#pieChart')[0].getContext('2d');
            new Chart(pieChart, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [data.ingresos, data.egresos, data.utilidades],
                        backgroundColor: ["#1d7af3", "#f2757bff", "#76d56bff"],
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
            document.getElementById('operaciones').innerHTML = '';
            data.operaciones.forEach(function (op) {
                var row = `<tr>
                                <td>${op.fecha}</td>
                                <td>${op.tipo}</td>
                                <td>${op.ingreso}</td>
                                <td>${op.egreso}</td>
                                <td>${op.saldo}</td>
                            </tr>`;
                
                $('#operaciones').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener los datos:", error);
        }
    });
}
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
/// ingresos formateo
const inputPrecioI = document.getElementById('montoi');
const inputConceptoI = document.getElementById('conceptoi');
const inputTipoI = document.getElementById('tipoi');

inputPrecioI.addEventListener('blur', function() {
    formatearPrecio(this);
});
inputConceptoI.addEventListener('blur', function() {
    convertirAMayusculas(this);
});
inputTipoI.addEventListener('blur', function() {
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
                        <td><button class="btn btn-icon btn-link btn-danger op-8 eliminar-btne">
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
function cargarOcupacion(periodo) {
    $.ajax({
        url: 'ocupaciones.php',
    type: 'GET',
    data: { periodo: periodo },
    dataType: 'json', // 👈 importante
    success: function(ocupacion) {
        const lisemp = $('#liocup');
        lisemp.empty();

            ocupacion.forEach(function (ocupa) {
                const ocupaHTML = `
                    <tr class="imsnhd">
                        <td>${ocupa.coach}</td>
                        <td>${ocupa.clases}</td>
                        <td>${ocupa.reservas}</td>
                        <td class="text-success">${ocupa.asistencias}</td>
                        <td>${ocupa.horas_totales}hrs</td>
                    </tr>
                `;
                lisemp.append(ocupaHTML);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar ocupaciones: ", error);
        }
    });
}

// Función para cargar la lista de egresos con el filtro de fecha
function cargarIngresos(filtroFecha = '') {
    $.ajax({
        url: 'listar_ingresos.php',
        type: 'GET',
        data: { fecha: filtroFecha }, // Enviar el filtro de fecha
        success: function(response) {
            const egresos = JSON.parse(response);
            const lisemp = $('#lisig');
            lisemp.empty(); // Limpiar la lista antes de cargar los nuevos datos

            egresos.forEach(function (egreso) {
                const egresoHTML = `
                    <tr class="imsnhd" data-id="${egreso.id}">
                        <td>${egreso.fecha}</td>
                        <td>${egreso.concepto}</td>
                        <td>${egreso.tipo}</td>
                        <td>${egreso.monto}</td>
                        <td><button class="btn btn-icon btn-link btn-danger op-8 eliminar-btni">
                            <i class="fas fa-ban"></i>
                        </button></td>
                    </tr>
                `;
                lisemp.append(egresoHTML);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar ingresos: ", error);
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
        case '1a':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 1); // Mes pasado
            break;
        case '2a':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 2); // Hace dos meses
            break;
        case '3a':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 3); // Hace tres meses
            break;
        case '1i':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 1); // Mes pasado
            break;
        case '2i':
            fechaFiltro.setMonth(fechaHoy.getMonth() - 2); // Hace dos meses
            break;
        case '3i':
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
    //carga balance
     $('.balanc').on('click', function() {
        const opcion = $(this).attr('id');
        const fechaFiltro = obtenerFechaFiltro(opcion);
        cargarBalance(fechaFiltro); // Recargar los egresos con el filtro aplicado

        // Actualizar el título del mes
        const nombreMes = {
            '': obtenerNombreMes(new Date()), // Mes actual
            '0a': obtenerNombreMes(new Date()), // Mes actual
            '1a': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 1))), // Mes pasado
            '2a': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 2))), // Hace dos meses
            '3a': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 3)))  // Hace tres meses
        };

        $('#tituloMeshome').text(`${nombreMes[opcion]}`); // Actualiza el título con el nombre del mes
    });

    // Cargar los egresos del mes actual por defecto
    cargarEgresos(obtenerFechaFiltro(''));
    cargarIngresos(obtenerFechaFiltro(''));

    // Mostrar el mes actual en el título
    $('#tituloMes').text(`${obtenerNombreMes(new Date())}`); // Mostrar "Egresos de Noviembre" (mes actual)
    $('#tituloMeshome').text(`${obtenerNombreMes(new Date())}`);
    $('#tituloMesIng').text(`${obtenerNombreMes(new Date())}`);
    // Filtrar por fecha seleccionada en el dropdown
    $('.deg').on('click', function() {
        const opcion = $(this).attr('id');
        const fechaFiltro = obtenerFechaFiltro(opcion);
        cargarEgresos(fechaFiltro); // Recargar los egresos con el filtro aplicado

        // Actualizar el título del mes
        const nombreMes = {
            '': obtenerNombreMes(new Date()), // Mes actual
            '0m': obtenerNombreMes(new Date()), // Mes actual
            '1m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 1))), // Mes pasado
            '2m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 2))), // Hace dos meses
            '3m': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 3)))  // Hace tres meses
        };

        $('#tituloMes').text(`${nombreMes[opcion]}`); // Actualiza el título con el nombre del mes
    });
    /// ingreso 
        $('.dig').on('click', function() {
        const opcion = $(this).attr('id');
        const fechaFiltro = obtenerFechaFiltro(opcion);
        cargarIngresos(fechaFiltro); // Recargar los egresos con el filtro aplicado

        // Actualizar el título del mes
        const nombreMes = {
            '': obtenerNombreMes(new Date()), // Mes actual
            '0i': obtenerNombreMes(new Date()), // Mes actual
            '1i': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 1))), // Mes pasado
            '2i': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 2))), // Hace dos meses
            '3i': obtenerNombreMes(new Date(new Date().setMonth(new Date().getMonth() - 3)))  // Hace tres meses
        };

        $('#tituloMesIng').text(`${nombreMes[opcion]}`); // Actualiza el título con el nombre del mes
    });
    // Eliminar un egreso al hacer clic en el botón de eliminar
    $('#liseg').on('click', '.eliminar-btne', function () {
        const egr = new Date();
        const egresoId = $(this).closest('.imsnhd').data('id');
         

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
                         cargarEgresos(obtenerFechaFiltro(''));
                         cargarBalance(obtenerFechaFiltro(''));
                        
                    },
                    error: function(xhr, status, error) {
                        swal("Error!", "Hubo un problema al eliminar al egreso.", "error");
                    }
                });
                
            }
            
        });
        
    });

    // Eliminar un ingreso al hacer clic en el botón de eliminar
    $('#lisig').on('click', '.eliminar-btni', function () {
        const egr = new Date();
        const egresoId = $(this).closest('.imsnhd').data('id');
       
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
                // Enviar solicitud para eliminar el ingreso
                $.ajax({
                    url: 'eliminar_ingreso.php',
                    type: 'POST',
                    data: { id: egresoId },
                    success: function(response) {
                        swal("Eliminado!", "El ingreso ha sido eliminado.", "success");
                         cargarIngresos(obtenerFechaFiltro(''));
                        cargarBalance(obtenerFechaFiltro(''));
                    },
                    error: function(xhr, status, error) {
                        swal("Error!", "Hubo un problema al eliminar al ingreso.", "error");
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
                closeF();
                cargarEgresos(obtenerFechaFiltro(''));
                cargarBalance(obtenerFechaFiltro(''));
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al registrar el usuario');
                console.error(error);
            }
        });
    });

    // Manejo del formulario de ingreso
    $('#ingreForm').on('submit', function (e) {
        e.preventDefault(); // Prevenir el envío del formulario tradicional

        // Recolectar los datos del formulario
        const formData = {
            fecha: $('#fechai').val(),
            concepto: $('#conceptoi').val(),
            tipo: $('#tipoi').val(),
            monto: $('#montoi').val()
        };

        // Enviar los datos con AJAX a un archivo PHP
        $.ajax({
            url: 'nuevo_ingreso.php',  // Ruta de tu archivo PHP
            type: 'POST',
            data: JSON.stringify(formData),  // Enviar los datos como JSON
            contentType: 'application/json',
            success: function(response) {

                $('#fechai').val('');
                $('#conceptoi').val('');
                $('#tipoi').val('');
                $('#montoi').val('');
                closeF();
                cargarIngresos(obtenerFechaFiltro(''));
                cargarBalance(obtenerFechaFiltro(''));
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al registrar el usuario');
                console.error(error);
            }
        });
    });


});
function newEgr() {
    document.getElementById('overl').style.display = 'block';
    document.getElementById('newegr').style.display = 'block';
}
function newIng() {
    document.getElementById('overl').style.display = 'block';
    document.getElementById('newing').style.display = 'block';
}
function closeF() {
    document.getElementById('overl').style.display = 'none';
    document.getElementById('newegr').style.display = 'none';
    document.getElementById('newing').style.display = 'none';
}
document.addEventListener("DOMContentLoaded", function () {
    // Calcular último rango de 7 días
    let hoy = new Date();
    let hace7 = new Date();
    hace7.setDate(hoy.getDate() - 7);

    // Inicializar flatpickr en el botón
    const picker = flatpickr("#btnPeriodo", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es", // 👈 Aquí activamos español
        defaultDate: [hace7, hoy], 
        onClose: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const inicio = instance.formatDate(selectedDates[0], "Y-m-d");
                const fin = instance.formatDate(selectedDates[1], "Y-m-d");
                const periodo = `${inicio}/${fin}`;
                console.log("Periodo seleccionado:", periodo);
                cargarOcupacion(periodo);
            }
        }
    });

    // Ejecutar al cargar el DOM con la última semana
    const inicioAuto = picker.formatDate(hace7, "Y-m-d");
    const finAuto = picker.formatDate(hoy, "Y-m-d");
    cargarOcupacion(`${inicioAuto}/${finAuto}`);
});