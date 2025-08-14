 $(document).ready(function() {
      // Función para formatear números
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Cargar métricas via AJAX
    $.ajax({
        url: 'get_visitor_metrics.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.message);
                return;
            }

            // Mostrar visitantes únicos
            $('#visit').text(formatNumber(response.visit));

            // Mostrar tiempo promedio (agregar 'min' si es mayor a 1 minuto)
            const timeText = response.timetot;
            $('#timetot').text(timeText);

            // Mostrar tasa de conversión con porcentaje
            $('#conver').text(`${response.conver}%`);

            // Mostrar página más vista (acortar si es muy larga)
            const maxLength = 30;
            let masVista = response.masvista;
            if (masVista.length > maxLength) {
                masVista = '...' + masVista.substring(masVista.length - maxLength);
            }
            $('#masvista').text(masVista || 'N/A');

            // Animación de conteo (opcional)
            $('.metric-value').each(function() {
                const $this = $(this);
                const originalText = $this.text();
                $this.css('opacity', 0).text('0').animate({
                    opacity: 1,
                    text: originalText
                }, 1000);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar métricas:", error);
            
            // Mostrar valores por defecto en caso de error
            $('#visit').text('0');
            $('#timetot').text('0 min');
            $('#conver').text('0%');
            $('#masvista').text('N/A');
        }
    });

    // Actualizar cada 5 minutos (opcional)
    setInterval(function() {
        $.ajax({
            url: 'get_visitor_metrics.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (!response.error) {
                    $('#visit').text(formatNumber(response.visit));
                    
                    const timeText = response.timetot >= 1 ? 
                        `${response.timetot} min` : 
                        `${Math.round(response.timetot * 60)} seg`;
                    $('#timetot').text(timeText);
                    
                    $('#conver').text(`${response.conver}%`);
                    
                    let masVista = response.masvista;
                    if (masVista.length > 30) {
                        masVista = '...' + masVista.substring(masVista.length - 30);
                    }
                    $('#masvista').text(masVista || 'N/A');
                }
            }
        });
    }, 300000); // 5 minutos
      // Cargar datos via AJAX
                    $.ajax({
                        url: 'get-visitas-index.php',
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
                                        label: "Usuarios Reales",
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
                    //conversion Chart
                     $.ajax({
                        url: 'get-conversion.php',
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
                    //mercado
          $.ajax({
                        url: 'get-location.php',
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
        
            // Cargar datos de páginas via AJAX top page visits
            $.ajax({
                url: 'get_top_pages.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#pageV');
                    tbody.empty(); // Limpiar tabla
                    
                    if (response.error) {
                        tbody.append('<tr><td colspan="4" class="text-center text-danger">Error al cargar datos</td></tr>');
                        console.error(response.message);
                        return;
                    }
                    
                    if (response.pages.length === 0) {
                        tbody.append('<tr><td colspan="4" class="text-center text-muted">No hay datos disponibles</td></tr>');
                        return;
                    }
                    
                    // Agregar cada fila de datos
                    response.pages.forEach(function(page) {
                        const trendIcon = page.bounce_trend ? 
                            '<i class="fas fa-arrow-up text-success me-2"></i>' : 
                            '<i class="fas fa-arrow-down text-warning me-2"></i>';
                        
                        const row = `
                            <tr>
                                <th scope="row" title="${page.full_url}">
                                    ${page.page_name}
                                </th>
                                <td>
                                    ${formatNumber(page.visitors)}
                                </td>
                                <td>
                                    ${formatNumber(page.unique_users)}
                                </td>
                                <td>
                                    ${trendIcon} ${page.bounce_rate}%
                                </td>
                            </tr>
                        `;
                        
                        tbody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar datos de páginas:", error);
                    $('#pageV').html('<tr><td colspan="4" class="text-center text-danger">Error al cargar datos</td></tr>');
                }
            });
            
            
             // Cargar datos de secciones via AJAX para top seccion
            $.ajax({
                url: 'get_top_sections.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#sectp');
                    tbody.empty();
                    
                    if (response.error) {
                        showError('Error al cargar datos');
                        return;
                    }
                    
                    if (response.sections.length === 0) {
                        showError('No hay datos de secciones disponibles');
                        return;
                    }
                    
                    // Agregar cada fila de datos
                    response.sections.forEach(function(section, index) {
                        const row = `
                            <tr>
                                <td title="${section.page_url}">
                                    ${section.page_name}
                                </td>
                                <td>
                                    ${section.section_id}
                                    ${index < 3 ? '<span class="badge bg-primary ms-2">Top</span>' : ''}
                                </td>
                                <td class="text-end" title="${section.avg_time_sec} segundos">
                                    ${section.avg_time}
                                </td>
                                <td class="text-end">
                                    ${formatNumber(section.visits)}
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    showError('Error al cargar datos');
                }
            });
        
            function showError(message) {
                $('#sectp').html(`
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${message}
                        </td>
                    </tr>
                `);
            }
             
 });