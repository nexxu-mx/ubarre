 function ocult(){
                    var estadistic = document.getElementById('estadistic');
                    var lead = document.getElementById('lead');
                    var curs = document.getElementById('curs');
                    var libr = document.getElementById('libr');
                    estadistic.style.display = "none";
                    lead.style.display = "none";
                    curs.style.display = "none";
                    libr.style.display = "none";
                }
            
                function vistis(){
                    var estadistic = document.getElementById('estadistic');
                    ocult();
                    estadistic.style.display = "block";
                }
                function lead() {
                    var lead = document.getElementById('lead');
                    ocult();
                    lead.style.display = "block";
                }
                function curs() {
                    var curs = document.getElementById('curs');
                    ocult();
                    curs.style.display = "block";
                }
                function libr() {
                    var libr = document.getElementById('libr');
                    ocult();
                    libr.style.display = "block";
                }
                
                $(document).ready(function() {
                     // Función para formatear números grandes
                        function formatNumber(num) {
                            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        }
                    
                        // Cargar estadísticas via AJAX
                        $.ajax({
                            url: 'get_academy_stats.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.error) {
                                    console.error(response.message);
                                    return;
                                }
                    
                                // Actualizar los valores en el DOM
                                $('#Tvisitas').text(formatNumber(response.Tvisitas));
                                $('#Tleads').text(formatNumber(response.Tleads));
                                $('#Tcyc').text(formatNumber(response.Tcyc));
                                $('#Tclientes').text(formatNumber(response.Tclientes));
                    
                                // Efectos de animación (opcional)
                                $('.zx0').each(function() {
                                    var $this = $(this);
                                    var countTo = $this.text().replace(/,/g, '');
                                    
                                    $({ countNum: 0 }).animate({
                                        countNum: countTo
                                    },
                                    {
                                        duration: 1000,
                                        easing: 'swing',
                                        step: function() {
                                            $this.text(formatNumber(Math.floor(this.countNum)));
                                        },
                                        complete: function() {
                                            $this.text(formatNumber(this.countNum));
                                        }
                                    });
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error al cargar estadísticas:", error);
                                
                                // Mostrar valores por defecto en caso de error
                                $('#Tvisitas').text('0');
                                $('#Tleads').text('0');
                                $('#Tcyc').text('0');
                                $('#Tclientes').text('0');
                            }
                        });
                    
                        // Actualizar cada 5 minutos (opcional)
                        setInterval(function() {
                            $.ajax({
                                url: 'get_academy_stats.php',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    if (!response.error) {
                                        $('#Tvisitas').text(formatNumber(response.Tvisitas));
                                        $('#Tleads').text(formatNumber(response.Tleads));
                                        $('#Tcyc').text(formatNumber(response.Tcyc));
                                        $('#Tclientes').text(formatNumber(response.Tclientes));
                                    }
                                }
                            });
                        }, 300000); // 5 minutos
                    
                    
                    
                    
                    // Cargar datos via AJAX
                    $.ajax({
                        url: 'get-visitas-academy.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            // Una vez recibidos los datos, crear la gráfica
                            var lineChart = document.getElementById('lineChart').getContext('2d');
                		
                            
                            var myLineChart = new Chart(lineChart, {
                                type: 'line',
                                data: {
                                    labels: response.labels,
                                    datasets: [{
                                        label: "Usuarios Únicos",
                                        borderColor: "#1d7af3",
                                        pointBorderColor: "#FFF",
                                        pointBackgroundColor: "#1d7af3",
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 4,
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 4,
                                        backgroundColor: 'transparent',
                                        fill: true,
                                        borderWidth: 2,
                                        data: response.data
                                    }]
                                },
                                options: {
                                    responsive: true, 
                                    maintainAspectRatio: false,
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 10,
                                            fontColor: '#1d7af3',
                                        }
                                    },
                                    tooltips: {
                                        bodySpacing: 4,
                                        mode:"nearest",
                                        intersect: 0,
                                        position:"nearest",
                                        xPadding:10,
                                        yPadding:10,
                                        caretPadding:10
                                    },
                                    layout:{
                                        padding:{left:15,right:15,top:15,bottom:15}
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0 // Para mostrar números enteros
                                            }
                                        }
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar datos:", error);
                            // Puedes mostrar una gráfica con datos vacíos o un mensaje de error
                        }
                    });
                    
                    //top visitas
                    
                    $.ajax({
                        url: 'get-top-academy.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                console.error(data.message);
                                return;
                            }
                            
                            var tbody = $('#vitisd');
                            tbody.empty(); // Limpiar tabla antes de agregar datos
                            
                            if (data.length === 0) {
                                tbody.append('<tr><td colspan="4">No hay datos de visitas disponibles</td></tr>');
                                return;
                            }
                            
                            // Agregar cada fila de datos
                            $.each(data, function(index, pagina) {
                                var ratingClass = (pagina.rating >= 50) ? 'text-success' : 'text-warning';
                                var ratingIcon = (pagina.rating >= 50) ? 'fa-arrow-up' : 'fa-arrow-down';
                                
                                var row = `
                                    <tr>
                                        <th scope="row">${pagina.nombre}</th>
                                        <td>${pagina.visitas.toLocaleString()}</td>
                                        <td>${pagina.unicos.toLocaleString()}</td>
                                        <td>
                                            <i class="fas ${ratingIcon} ${ratingClass} me-3"></i> ${pagina.rating}%
                                        </td>
                                    </tr>
                                `;
                                
                                tbody.append(row);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar datos:", error);
                            $('#vitisd').html('<tr><td colspan="4">Error al cargar los datos</td></tr>');
                        }
                    });
                    
                    
                    
                    $.ajax({
                        url: 'get-conversion-academy.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                console.error(response.message);
                                return;
                            }
                            
                            var pieChart = document.getElementById('conversionChart').getContext('2d');
                            
                            var myPieChart = new Chart(pieChart, {
                                type: 'pie',
                                data: {
                                    datasets: [{
                                        data: response.data,
                                        backgroundColor: response.colors,
                                        borderWidth: 0
                                    }],
                                    labels: response.labels
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
                                    plugins: {
                                        tooltip: {
                                            enabled: false
                                        },
                                        datalabels: {
                                            formatter: (value, ctx) => {
                                                let sum = ctx.dataset._meta[0].total;
                                                let percentage = (value * 100 / sum).toFixed(1) + '%';
                                                return percentage;
                                            },
                                            color: 'white',
                                            font: {
                                                size: 14
                                            }
                                        }
                                    },
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
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar datos de conversión:", error);
                            
                            // Mostrar gráfica vacía en caso de error
                            var pieChart = document.getElementById('conversionChart').getContext('2d');
                            var myPieChart = new Chart(pieChart, {
                                type: 'pie',
                                data: {
                                    datasets: [{
                                        data: [1, 0, 0],
                                        backgroundColor: ["#1d7af3","#f3545d","#fdaf4b"],
                                        borderWidth: 0
                                    }],
                                    labels: ['Error', 'Error', 'Error']
                                },
                                options: {
                                    responsive: true, 
                                    maintainAspectRatio: false
                                }
                            });
                        }
                    });
                    
                    
                     $.ajax({
                        url: 'get-location-academy.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                console.error(response.message);
                                return;
                            }
                
                            var doughnutChart = document.getElementById('doughnutChart').getContext('2d');
                            
                            var myDoughnutChart = new Chart(doughnutChart, {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: response.data, // Usamos los porcentajes directamente
                                        backgroundColor: response.colors,
                                        borderWidth: 0
                                    }],
                                    labels: response.labels
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
                                            padding: 20,
                                            // Mostrar porcentaje en la leyenda
                                            generateLabels: function(chart) {
                                                const data = chart.data;
                                                return data.labels.map((label, i) => ({
                                                    text: `${label} (${data.datasets[0].data[i]}%)`,
                                                    fillStyle: data.datasets[0].backgroundColor[i],
                                                    hidden: false
                                                }));
                                            }
                                        }
                                    },
                                    tooltips: {
                                        callbacks: {
                                            label: function(tooltipItem, data) {
                                                const label = data.labels[tooltipItem.index] || '';
                                                const value = data.datasets[0].data[tooltipItem.index];
                                                return `${label}: ${value}%`;
                                            }
                                        }
                                    },
                                    cutoutPercentage: 70,
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
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar datos:", error);
                            
                            // Gráfica de ejemplo en caso de error
                            var doughnutChart = document.getElementById('doughnutChart').getContext('2d');
                            new Chart(doughnutChart, {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: [100],
                                        backgroundColor: ['#cccccc']
                                    }],
                                    labels: ['Datos no disponibles']
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        }
                    });
                    
                    
                     // Inicializar DataTable de LEADS
                    var table = $('#basic-datatables').DataTable({
                        ajax: {
                            url: 'get-leads-academy.php',
                            dataSrc: 'data'
                        },
                        columns: [
                            { data: 'nombre' },
                            { data: 'telefono' },
                            { data: 'email' },
                            { data: 'interes' },
                            { data: 'ubicacion' },
                            { 
                                data: 'estatus',
                                render: function(data, type, row) {
                                    return type === 'display' ? data : (data.includes('pagado') ? 'pagado' : 'no pagado');
                                }
                            }
                        ],
                        
                        responsive: true,
                        order: [[0, 'asc']],
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        initComplete: function() {
                           
                        }
                    });
                    
                     $.ajax({
                        url: 'get-cursos.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                console.error(response.message);
                                $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los cursos</div></div>');
                                return;
                            }
                            
                            if (response.cursos.length === 0) {
                                $('#cursos').html('<div class="col-12"><div class="alert alert-info">No hay cursos disponibles</div></div>');
                                return;
                            }
                            
                            // Generar las tarjetas de cursos
                            var cursosHTML = '';
                            
                            response.cursos.forEach(function(curso) {
                                  var imgAutor = "unknnow";
                                if(curso.autor == "Diana González"){
                                    imgAutor = "diana";
                                } else if(curso.autor == "Michel Gómez"){
                                    imgAutor = "michel";
                                }
                                cursosHTML += `
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-post card-round">
                                            <img class="card-img-top" src="uploads/${curso.imagen}" alt="${curso.nombre}">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="avatar">
                                                        <img src="assets/img/${imgAutor}.png" alt="${curso.autor}" class="avatar-img rounded-circle">
                                                    </div>
                                                    <div class="info-post ms-2">
                                                        <p class="username">${curso.autor}</p>
                                                        <p class="date text-muted">${curso.fecha}</p>
                                                    </div>
                                                </div>
                                                <div class="separator-solid"></div>
                                                <h3 class="card-title">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#cursoModal${curso.id}">${curso.nombre}</a>
                                                </h3>
                                                <p class="card-text text-muted">${curso.descripcion.substring(0, 100)}${curso.descripcion.length > 100 ? '...' : ''}</p>
                                                <div class="d-flex justify-content-between">
                                                    <a href="./editar-cursos.php?id=${curso.id}" class="btn btn-primary btn-rounded btn-sm"><i class="far fa-edit"></i> Editar</a>
                                                    <button class="btn btn-outline-secondary btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#cursoModal${curso.id}">
                                                        Ver más
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            
                            $('#cursos').html(cursosHTML);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar cursos:", error);
                            $('#cursos').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los cursos</div></div>');
                        }
                    });
                    
                    
                    
                    
                    
                     // Cargar recursos via AJAX
    $.ajax({
        url: 'get-recursos.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.message);
                $('#librs').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los recursos</div></div>');
                return;
            }
            
            if (response.recursos.length === 0) {
                $('#librs').html('<div class="col-12"><div class="alert alert-info">No hay recursos disponibles</div></div>');
                return;
            }
            
            // Generar las tarjetas de recursos
            var recursosHTML = '';
            
            response.recursos.forEach(function(recurso) {
                var imgAutor = "unknnow";
                if(recurso.autor == "Diana González"){
                    imgAutor = "diana";
                } else if(recurso.autor == "Michel Gómez"){
                    imgAutor = "michel";
                }
                recursosHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card card-post card-round">
                            <div class="card-img-top-container">
                                <img class="card-img-top" src="uploads/${recurso.imagen}" alt="${recurso.nombre}">
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2">${recurso.tipo}</span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="avatar">
                                        <img src="assets/img/${imgAutor}.png" alt="${recurso.autor}" class="avatar-img rounded-circle">
                                    </div>
                                    <div class="info-post ms-2">
                                        <p class="username">${recurso.autor}</p>
                                        <p class="date text-muted">${recurso.fecha}</p>
                                    </div>
                                </div>
                                <div class="separator-solid"></div>
                                <h3 class="card-title">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#recursoModal${recurso.id}">${recurso.nombre}</a>
                                </h3>
                                <p class="card-text text-muted">${recurso.descripcion.substring(0, 100)}${recurso.descripcion.length > 100 ? '...' : ''}</p>
                                <div class="d-flex justify-content-between">
                                    <a href="./editar-recursos.php?id=${recurso.id}" class="btn btn-primary btn-rounded btn-sm"><i class="far fa-edit"></i> Editar</a>
                                    <button class="btn btn-outline-secondary btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#recursoModal${recurso.id}">
                                        Ver más
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            $('#librs').html(recursosHTML);
            generarModalesRecursos(response.recursos);
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar recursos:", error);
            $('#librs').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los recursos</div></div>');
        }
    });

    // Función para generar modales dinámicos para recursos
    function generarModalesRecursos(recursos) {
        const modalTemplate = `
            <div class="modal fade" id="recursoModal{{id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{nombre}} <span class="badge bg-primary ms-2">{{tipo}}</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{imagen}}" alt="{{nombre}}" class="img-fluid rounded">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex mb-3">
                                        <div class="avatar">
                                            <img src="assets/img/{{autor}}.png" alt="{{autor}}" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="info-post ms-2">
                                            <p class="username">{{autor}}</p>
                                            <p class="date text-muted">{{fecha}}</p>
                                        </div>
                                    </div>
                                    <p>{{descripcion}}</p>
                                    <div class="mt-3">
                                        <h6>Detalles:</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Tipo de recurso
                                                <span class="badge bg-primary rounded-pill">{{tipo}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./editar-recursos.php?id={{id}}" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        recursos.forEach(recurso => {
            let modalHTML = modalTemplate
                .replace(/{{id}}/g, recurso.id)
                .replace(/{{nombre}}/g, recurso.nombre)
                .replace(/{{imagen}}/g, recurso.imagen)
                .replace(/{{autor}}/g, recurso.autor)
                .replace(/{{fecha}}/g, recurso.fecha)
                .replace(/{{descripcion}}/g, recurso.descripcion)
                .replace(/{{tipo}}/g, recurso.tipo);
            
            $('body').append(modalHTML);
        });
    }
                   
                    
                });
        

		

	