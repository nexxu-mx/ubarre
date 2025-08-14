 $(document).ready(function() {
     // Función para formatear números grandes
                        function formatNumber(num) {
                            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        }
                    
                        // Cargar estadísticas via AJAX
                        $.ajax({
                            url: 'get-gral-stats.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response.error) {
                                    console.error(response.message);
                                    return;
                                }
                    
                                // Actualizar los valores en el DOM
                                $('#Ivisitas').text(formatNumber(response.visitas));
                                $('#Ileads').text(formatNumber(response.leads));
                                $('#Icyc').text(formatNumber(response.cyc));
                                $('#Iclientes').text(formatNumber(response.clientes));
                    
                                // Efectos de animación (opcional)
                                $('.ca33').each(function() {
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
                                $('#Ivisitas').text('0');
                                $('#Ileads').text('0');
                                $('#Icyc').text('0');
                                $('#Iclientes').text('0');
                            }
                        });
                    
                        // Actualizar cada 5 minutos (opcional)
                        setInterval(function() {
                            $.ajax({
                                url: 'get-gral-stats.php',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    if (!response.error) {
                                        $('#Ivisitas').text(formatNumber(response.visitas));
                                        $('#Ileads').text(formatNumber(response.leads));
                                        $('#Icyc').text(formatNumber(response.cyc));
                                        $('#Iclientes').text(formatNumber(response.clientes));
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
                    
                     $.ajax({
                        url: 'get-last-leads.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const leadsContainer = $('#leadsrec');
                            leadsContainer.empty(); // Limpiar contenedor
                            
                            if (response.error) {
                                leadsContainer.append('<div class="text-muted">Error al cargar leads</div>');
                                console.error(response.message);
                                return;
                            }
                            
                            if (response.leads.length === 0) {
                                leadsContainer.append('<div class="text-muted">No hay leads recientes</div>');
                                return;
                            }
                            
                            // Generar HTML para cada lead
                            response.leads.forEach(lead => {
                                const leadHTML = `
                                    <div class="item-list d-flex align-items-center mb-3">
                                        <div class="avatar">
                                            <span class="avatar-title rounded-circle border border-white bg-primary text-white">${lead.iniciales}</span>
                                        </div>
                                        <div class="info-user ms-3">
                                            <div class="username">${lead.nombre_completo}</div>
                                            <div class="status text-muted small">$${lead.monto} | ${lead.credits} Créditos</div>
                                        </div>
                                    </div>
                                `;
                                leadsContainer.append(leadHTML);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar leads:", error);
                            $('#leadsrec').html('<div class="text-muted">Error al cargar leads</div>');
                        }
                    });
                
                    // Actualizar cada 2 minutos (opcional)
                    setInterval(function() {
                        $.ajax({
                            url: 'get-last-leads.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (!response.error && response.leads) {
                                    $('#leadsrec').empty();
                                    response.leads.forEach(lead => {
                                        $('#leadsrec').append(`
                                            <div class="item-list d-flex align-items-center mb-3">
                                                <div class="avatar">
                                                    <span class="avatar-title rounded-circle border border-white bg-primary text-white">${lead.iniciales}</span>
                                                </div>
                                                <div class="info-user ms-3">
                                                    <div class="username">${lead.nombre_completo}</div>
                                                    <div class="status text-muted small">$${lead.monto} | ${lead.credits} Créditos</div>
                                                </div>
                                            </div>
                                        `);
                                    });
                                }
                            }
                        });
                    }, 120000); // 2 minutos 
                    
 });