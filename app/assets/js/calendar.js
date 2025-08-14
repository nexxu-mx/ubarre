document.addEventListener('DOMContentLoaded', function () {
    renderCalendar();
  });
  function cargarOpciones() {
    fetch('get_disciplinas_couches.php')
      .then(response => response.json())
      .then(data => {
        const disciplinaSelect = document.getElementById('disciplina-select');
        const coachSelect = document.getElementById('coach-select');
  
        disciplinaSelect.innerHTML = '';
        coachSelect.innerHTML = '';
  
        data.disciplinas.forEach(d => {
          const option = document.createElement('option');
          option.value = d.id;
          option.textContent = d.nombre_disciplina;
          disciplinaSelect.appendChild(option);

        });
  
        data.couches.forEach(c => {
          const option = document.createElement('option');
          option.value = c.id;
          option.textContent = c.nombre_coach;
          coachSelect.appendChild(option);
        });
      });
  }

  
  let calendar;

function renderCalendar() {
  const calendarEl = document.getElementById('calendar');
  calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    editable: true,
    locale: 'es',
    events: 'get_events.php',
    eventColor: '#378006',
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      hour12: true
    },

   dateClick: function (info) {
    const fechaSeleccionada = new Date(info.date);
    document.getElementById('oves').style.display = 'block';
    document.getElementById('evento-form').style.display = 'block';
    document.getElementById('fech').innerHTML = fechaSeleccionada.toLocaleDateString('es-ES', { day: 'numeric', month: 'long' });

    document.getElementById('form-evento').onsubmit = function (e) {
        e.preventDefault();

        const disciplina = document.getElementById('disciplina-select').value;
        const coach = document.getElementById('coach-select').value;
        const horain = document.getElementById('hora-inicio').value;
        const horafin = document.getElementById('hora-fin').value;
        const afoo = document.getElementById('aforo-select').value;

        const diasSeleccionados = Array.from(document.querySelectorAll('input[name="dayrepeat"]:checked'))
            .map(cb => parseInt(cb.value));

        const eventos = [];
        const fechaInicio = new Date(fechaSeleccionada);
        
        // Si no hay días seleccionados, solo crea el evento para la fecha seleccionada
        if (diasSeleccionados.length === 0) {
            const yearStr = fechaInicio.getFullYear();
            const monthStr = String(fechaInicio.getMonth() + 1).padStart(2, '0');
            const dayStr = String(fechaInicio.getDate()).padStart(2, '0');
            const fechaStr = `${yearStr}-${monthStr}-${dayStr}`;

            eventos.push({
                title: disciplina,   
                start: fechaStr,     
                end: fechaStr,       
                horain: horain,      
                horafin: horafin,   
                coach: coach,
                aforo: afoo
            });
        } else {
            // Si hay días seleccionados, crea eventos para esos días durante el mes
            const year = fechaInicio.getFullYear();
            const month = fechaInicio.getMonth();
            const fechaFin = new Date(year, month + 1, 0); // último día del mes

            for (let d = new Date(fechaInicio); d <= fechaFin; d.setDate(d.getDate() + 1)) {
                if (diasSeleccionados.includes(d.getDay())) {
                    const yearStr = d.getFullYear();
                    const monthStr = String(d.getMonth() + 1).padStart(2, '0');
                    const dayStr = String(d.getDate()).padStart(2, '0');
                    const fechaStr = `${yearStr}-${monthStr}-${dayStr}`;

                    eventos.push({
                        title: disciplina,   
                        start: fechaStr,     
                        end: fechaStr,       
                        horain: horain,      
                        horafin: horafin,   
                        coach: coach,
                        aforo: afoo
                    });
                }
            }
        }

        console.log("Eventos a crear:", eventos);

        fetch('add_event.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(eventos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
            } else {
                alert('Error al crear eventos');
            }
            closeEv();
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
            alert('Error al crear eventos');
        });
    };

    cargarOpciones();
},

    eventClick: function(info) {
      info.jsEvent.preventDefault();
      openEventModal(info.event);
    }
  });

  calendar.render();
}

function openEventModal(event) {
  document.getElementById('modalTitulo').textContent = event.title;
  document.getElementById('aforo').textContent = event.extendedProps.aforo;
  document.getElementById('modalInicio').textContent = event.start.toLocaleString();
  document.getElementById('modalFin').textContent = event.end.toLocaleString();
  document.getElementById('modalInstructor').textContent = event.extendedProps.coach || "No especificado";
  document.getElementById('modalDuracion').textContent = event.extendedProps.dura || "No especificado";
  document.getElementById("alumnos").innerHTML = event.extendedProps.alumnos;

  if (event.extendedProps.open == true) {
    document.getElementById("buttonModal").innerHTML = `
      <button class="btn btn-danger" onclick="cancelClass(${event.id})">
        <span class="btn-label"><i class="fas fa-times"></i></span>
        Cancelar Clase
      </button>
      <button class="btn btn-primary" onclick="addClient(${event.id}, '${event.title}', '${event.extendedProps.coach}', '${event.extendedProps.dura}', ${event.extendedProps.idcoach})">
        <span class="btn-label"><i class="fas fa-user-plus"></i></span>
      </button>`;
  } else {
    document.getElementById("buttonModal").innerHTML = `
      <button class="btn btn-danger" onclick="cancelClass(${event.id})">
        <span class="btn-label"><i class="fas fa-times"></i></span>
        Cancelar Clase
      </button>`;
  }

  document.getElementById('eventoModal').style.display = "flex";
  document.getElementById('oves').style.display = "block";
  setTimeout(() => {
    document.getElementById('modal-content').classList.add("Act");
  }, 50);
}


  function addClient(id_event, disciplina, coach, duracion, idcoach){
      document.getElementById('id-event').value = id_event;
      document.getElementById('disciplina-event').value = disciplina;
      document.getElementById('coach-event').value = coach;
      document.getElementById('duracion-event').value = duracion;
      document.getElementById('idcoach-event').value = idcoach;
      document.getElementById('add_alumnos').style.display = "flex";
  }
  function registrarReservaInterna() {
  const idEvento = document.getElementById('id-event').value;
  const disciplina = document.getElementById('disciplina-event').value;
  const coach = document.getElementById('coach-event').value;
  const duracion = document.getElementById('duracion-event').value;
  const idCoach = document.getElementById('idcoach-event').value;
  const idAlumno = document.getElementById('alumn-event').value;
  

  // Validar que haya alumno seleccionado
  if (!idAlumno) {
    alert("Por favor selecciona un alumno");
    return;
  }

  fetch('../registrar-reserva-interna.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      id_event: idEvento,
      disciplina: disciplina,
      coach: coach,
      duracion: duracion,
      id_coach: idCoach,
      id_alumno: idAlumno
    })
  })
  .then(response => response.json())
  .then(data => {
        if (data.success) {
        
             renderCalendar();
        
          closeEv();
        }

  })
  .catch(error => {
    console.error('Error en la solicitud:', error);
  });
}

  function closeEv() {
    document.getElementById('eventoModal').style.display = "none";
    document.getElementById('evento-form').style.display = 'none';
    document.getElementById('oves').style.display = "none";
  }

  function cancelReserv(eventId, userId, clasId, tieneInvitado, title) {
    if (confirm("¿Cancelar esta reservación?")) {
      const datos = new URLSearchParams();
      datos.append("evento", eventId);
      datos.append("usuario", userId);
      datos.append("classID", clasId);
      datos.append("title", title);
      datos.append("invitado", tieneInvitado);
  
      fetch("../cancel_reserv.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: datos.toString()
      })
      .then(response => response.text())
      .then(data => {
       
        renderCalendar();
        closeEv();
           
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Hubo un error al cancelar.");
      });
    }
  }

  function cerrarFormulario() {
    closeEv();
    
  }
  
  function addInvitado(eventId, userId, clasId) {
    if (confirm("¿Deseas agregar un invitado?")) {
        const datos = new URLSearchParams();
        datos.append("evento", eventId);
        datos.append("usuario", userId);
        datos.append("classID", clasId);

        fetch("add_invitado.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: datos.toString()
        })
        .then(response => response.json()) // <-- aquí cambiamos a .json()
        .then(data => {
            if (data.status === "nocredit") {
                alert("No cuenta con Créditos disponibles.");
                return; // No seguimos ejecutando el resto
            }

            renderCalendar();
            closeEv();
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Hubo un error al cancelar.");
        });
    }
}
function cancelClass(id) {
    if (!confirm("¿Estás seguro de que quieres eliminar esta clase?")) return;

    fetch('eliminar-clase.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.text())
    .then(data => {
        if (data === "ok") {
            renderCalendar();
            closeEv();
        } else {
            alert(data);
            renderCalendar();
            closeEv();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error en la solicitud.");
    });
}