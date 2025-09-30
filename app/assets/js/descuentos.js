
function getPaquetes() {
    $.ajax({
        url: 'get-descuentos.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.error(response.message);
                $('#paquetes').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los códigos de descuentos</div></div>');
                return;
            }

            if (response.paquetes.length === 0) {
                $('#paquetes').html('<div class="col-12"><div class="alert alert-info">No hay códigos de descuentos disponibles</div></div>');
                return;
            }

            // Generar las tarjetas de cursos
            var paquetesHTML = '';

            response.paquetes.forEach(function (paquete) {
                paquetesHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card card-post card-round">
                            <div class="card-body">
                                <div style="display: flex;justify-content: end;">
                                    <div class="checkbox-apple">
                                    <input class="yep" id="check-apple-${paquete.id}" type="checkbox" data-id="${paquete.id}">
                                    <label for="check-apple-${paquete.id}"></label>
                                    </div>
                                </div>
                                <h3 class="card-title">
                                    <a href="#" data-bs-toggle="modal" style="text-transform: uppercase;" data-bs-target="#cursoModal${paquete.id}">${paquete.codigo}</a>
                                </h3>
                                <div class="separator-solid"></div>
                               
                                <div class="d-flex justify-content-between">
                                    <p class="card-text text-muted">Descuento: <b>${paquete.descuento}%</b></p>
                                    <p class="card-text text-muted">Finaliza: ${paquete.finaliza}</p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-secondary btn-rounded btn-sm" onclick="eliminarPaquete(${paquete.id})"">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#paquetes').html(paquetesHTML);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar paquetes:", error);
            $('#paquetes').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los códigos de descuentos</div></div>');
        }
    });
}
$(document).ready(function () {
    getPaquetes();
    cargarEstados();
});

function eliminarPaquete(id) {
    fetch('./eliminar-descuento.php', {
        method: 'POST',
        headers: {
            'content-type': 'application/json'
        },
        body: JSON.stringify({
            paquete: id
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Se eliminó el código de descuento");
                getPaquetes();
                cargarEstados();
            } else {
                alert("Hubo un error al eliminar el código de descuento");
            }
        })
        .catch(error => console.error(error));
}
function submitFormD() {
     // Obtener valores y formatear
    const codigo = document.getElementById('codigo').value.trim();
    const descuento = document.getElementById('descuento').value.trim();
    const finaliza = document.getElementById('finaliza').value.trim();
    const restriccion = document.getElementById('restriccion').value;

    // Validaciones simples
    if (!codigo) {
        alert('El código es obligatorio');
        return;
    }
    if (!descuento || isNaN(descuento) || descuento < 0 || descuento > 100) {
        alert('Descuento inválido (0-100)');
        return;
    }
    if (!finaliza) {
        alert('Debe seleccionar una fecha de expiración');
        return;
    }

    // Preparar datos
    const datos = new FormData();
    datos.append('codigo', codigo);
    datos.append('descuento', descuento);
    datos.append('finaliza', finaliza);
    datos.append('restriccion', restriccion);

    // Enviar con fetch
    fetch('alta-codigo.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.text())
    .then(resultado => {
        closeFormD();
        getPaquetes();
        cargarEstados();

    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al enviar el formulario');
    });
}

function openFormD() {
    document.getElementById('over').style.display = "block";
    document.getElementById('new-code-form').style.display = "block";
}
function closeFormD() {
    document.getElementById('over').style.display = "none";
    document.getElementById('new-code-form').style.display = "none";

    document.getElementById('codigo').value = '';
    document.getElementById('descuento').value = '';
    document.getElementById('finaliza').value = '';
    document.getElementById('restriccion').value = '';

    
}

function enviarEstado(id, estado) {
			fetch("actualizar_estado_descuentos.php", {
				method: "POST",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify({ id, estado })
			})
			.then(res => res.json())
			.then(data => console.log("Servidor:", data))
			.catch(err => console.error("Error:", err));
			
		}
		// escuchamos en el contenedor general
	document.addEventListener('change', e => {
	if (e.target.matches('.yep')) {
		const el = e.target; 
		console.log(el.dataset.id); // ahora sí existe
		const id = el.dataset.id;
		const estado = el.checked ? 1 : 0;
		enviarEstado(id, estado);
	}
	});
	function cargarEstados() {
		fetch("obtener_estados_descuentos.php")
			.then(res => res.json())
			.then(data => {
			data.forEach(item => {
				const chk = document.querySelector(`.yep[data-id="${item.id}"]`);
				if (chk) {
				chk.checked = (item.activo === 1);
				}
			});
			})
			.catch(err => console.error("Error al cargar estados:", err));
	}