function openInicio() {
    document.getElementById('profile-calendario').style.display = 'none';
    document.getElementById('profile-medios').style.display = 'none';
    document.getElementById('profile-perfil').style.display = 'none';
    document.getElementById('profile-inicio').style.display = 'block';
    NameCredit();
    
}
function openClases() {
    window.location.href = 'reserva.php';
}

function openPaquetes() {
    window.location.href = 'paquetes.php';
}
function openAdmin() {
    window.location.href = './app/index.php';
}
function closeSession() {
    window.location.href = 'logout.php';
}
function openPerfil() {
    document.getElementById('profile-inicio').style.display = 'none';
    document.getElementById('profile-perfil').style.display = 'block';
 
}
function openPayment() {
    document.getElementById('profile-inicio').style.display = 'none';
    actualizarCards();
    document.getElementById('profile-medios').style.display = 'block';
 
}

function openCalendar() {
    document.getElementById('profile-inicio').style.display = 'none';
    document.getElementById('profile-calendario').style.display = 'block';



var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
initialView: window.innerWidth < 768 ? 'listWeek' : 'listWeek',
headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,listWeek'
},
locale: 'es',
events: 'fetch-events.php',

eventClick: function(info) {
    info.jsEvent.preventDefault();
    document.getElementById('modalTitulo').textContent = info.event.title;
    document.getElementById('aforo').textContent = info.event.extendedProps.aforo;
    document.getElementById('modalInicio').textContent = info.event.start.toLocaleString();
    document.getElementById('modalInstructor').textContent = info.event.extendedProps.instructor || "No especificado";
    document.getElementById('modalDuracion').textContent = info.event.extendedProps.dura || "No especificado";
    document.getElementById("clastatus").innerHTML = info.event.extendedProps.estatus;
    document.getElementById("qrcode").innerHTML = "";
    var data = info.event.extendedProps.qr;
    new QRCode(document.getElementById("qrcode"), {
        text: data,
        width: 300,
        height: 300
    });
    var invit = parseInt(info.event.extendedProps.invitado) + 1;

        document.getElementById('modalInvitado').innerHTML = `<ion-icon name="person" aria-hidden="true"></ion-icon> x${invit}`;
    
    if(info.event.extendedProps.cancelable === true){
        document.getElementById("buttonModal").innerHTML = `
            <button class="m11" onclick="cancelReserv(${info.event.id}, ${info.event.extendedProps.alumno}, ${info.event.extendedProps.classID}, ${info.event.extendedProps.invitado}, '${info.event.title}')">
                <ion-icon name="close-circle-outline" aria-hidden="true"></ion-icon>
                Cancelar
            </button>
            `; 
    }
    
    if(info.event.extendedProps.invitable === true){
        document.getElementById("invitarModal").innerHTML = `
            <button class="m10" onclick="addInvitado(${info.event.id}, ${info.event.extendedProps.alumno}, ${info.event.extendedProps.classID})">
                <ion-icon name="person-add-outline" aria-hidden="true"></ion-icon> 
                Agregar Persona
            </button>
            `;  
    }
    

    // Mostrar el modal 
        document.getElementById('eventoModal').style.display = "flex";
        setTimeout(function() {
            document.getElementById('modal-content').classList.add("Act");
        }, 50);
        }
        });

        calendar.render();

        // Cerrar el modal
        document.getElementById('cerrarModal').onclick = function () {
        setTimeout(function() {
            document.getElementById('eventoModal').style.display = "none";
        }, 500);
        document.getElementById('modal-content').classList.remove("Act");
        };

        // Cerrar al hacer clic fuera del modal
        window.onclick = function(event) {
        const modal = document.getElementById('eventoModal');
        const emodal = document.getElementById('modal-content');
        if (event.target == modal) {
            setTimeout(function() {
            modal.style.display = "none";
            }, 500);
            emodal.classList.remove("Act");

        }
        };
}

function coachCalendar() {
    document.getElementById('profile-inicio').style.display = 'none';
    document.getElementById('profile-calendario').style.display = 'block';



var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
initialView: window.innerWidth < 768 ? 'listWeek' : 'listWeek',
headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,listWeek'
},
locale: 'es',
events: 'coach-fetch-events.php',

eventClick: function(info) {
    info.jsEvent.preventDefault();
    document.getElementById('modalTitulo').textContent = info.event.title;
    document.getElementById('aforo').textContent = info.event.extendedProps.aforo;
    document.getElementById('modalInicio').textContent = info.event.start.toLocaleString();
    document.getElementById('modalInstructor').textContent = info.event.extendedProps.instructor || "No especificado";
    document.getElementById('modalDuracion').textContent = info.event.extendedProps.dura || "No especificado";
    document.getElementById("clastatus").innerHTML = info.event.extendedProps.estatus;
    document.getElementById("qrcode").innerHTML = "";
    document.getElementById("qrcode").innerHTML = info.event.extendedProps.alm;
  
   
    // Mostrar el modal
        document.getElementById('eventoModal').style.display = "flex";
        setTimeout(function() {
            document.getElementById('modal-content').classList.add("Act");
        }, 50);
        }
        });

        calendar.render();

        // Cerrar el modal
        document.getElementById('cerrarModal').onclick = function () {
        setTimeout(function() {
            document.getElementById('eventoModal').style.display = "none";
        }, 500);
        document.getElementById('modal-content').classList.remove("Act");
        };

        // Cerrar al hacer clic fuera del modal
        window.onclick = function(event) {
        const modal = document.getElementById('eventoModal');
        const emodal = document.getElementById('modal-content');
        if (event.target == modal) {
            setTimeout(function() {
            modal.style.display = "none";
            }, 500);
            emodal.classList.remove("Act");

        }
        };
}
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

function openPerfil() {
    document.getElementById('profile-inicio').style.display = 'none';
    document.getElementById('profile-perfil').style.display = 'block';
}
function NameCredit() {
    fetch("get_user_info.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            document.getElementById("name").textContent = data.nombre;
            document.getElementById("credits").textContent = `${data.credit} Créditos`;
        if (data.credit > 0 && data.fechaCredit) {
                // Formatear fecha a dd/mm (puedes hacer con JS)
                const fecha = new Date(data.fechaCredit);
                const dia = fecha.getDate().toString().padStart(2, '0');
                const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                document.getElementById("vence").textContent = `Vencen: ${dia}/${mes}`;
            } else {
                document.getElementById("vence").textContent = "";
            }
        })
        .catch(error => console.error("Error al obtener los datos:", error));
}

document.addEventListener('DOMContentLoaded', function () {
    NameCredit();
    const urlParams = new URLSearchParams(window.location.search);
    const setParam = urlParams.get('set');

    if (setParam === 'reservaciones') {
        openCalendar();
    }
    if (setParam === 'profile') {
        openPerfil();
    }
});

function eliminarCard(id) {
    fetch('eliminar_card.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ card_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            actualizarCards(); // si se eliminó, recargamos la lista
        } else {
            alert('Error al eliminar la tarjeta');
        }
    })
    .catch(error => console.error('Error:', error));
}
function cancelarEvent(id) {
    fetch('cancel_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ card_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            openCalendar(); // si se eliminó, recargamos la lista
            NameCredit();
        } else {
            alert('Error al eliminar la tarjeta');
        }
    })
    .catch(error => console.error('Error:', error));
}

function actualizarCards() {
    fetch('get_cards.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('myCards').innerHTML = html;
            const gradients = [
                "linear-gradient(135deg, #1e3c72 40%, #2a5298 60%)",
                "linear-gradient(135deg, #ff512f 40%, #dd2476 60%)",
                "linear-gradient(135deg, #00c6ff 40%, #0072ff 60%)",
                "linear-gradient(135deg, #56ab2f 40%, #a8e063 60%)",
                "linear-gradient(135deg, #e65c00 40%, #f9d423 60%)",
                "linear-gradient(135deg, #614385 40%, #516395 60%)"
            ];
        
            const cards = document.querySelectorAll(".use-card-btn");
        
            if (cards.length > 0) {
                cards.forEach((card, index) => {
                    if (index < gradients.length) {
                        card.style.background = gradients[index];
                    }
                });
            }
        });
}
 

    //Datos de Perfil
    document.addEventListener("DOMContentLoaded", () => {
        cargarOpcionesFecha(); // <- primero cargar los selects
    
        fetch("get_data.php")
            .then(res => res.json())
            .then(data => {
                if (data.error) return alert(data.error);
    
                document.getElementById("nombre").value = data.nombre;
                document.getElementById("mail").value = data.mail;
                document.getElementById("numero").value = data.numero;
    
                document.getElementById("dia").value = data.dia;
                document.getElementById("mes").value = data.mes;
                document.getElementById("anio").value = data.anio;
            });
    
        document.getElementById("guardarBtn").addEventListener("click", () => {
            const payload = {
                nombre: document.getElementById("nombre").value,
                mail: document.getElementById("mail").value,
                numero: document.getElementById("numero").value,
                dia: document.getElementById("dia").value,
                mes: document.getElementById("mes").value,
                anio: document.getElementById("anio").value
            };
    
            fetch("update_user_data.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    NameCredit();
                    openInicio();
                } else {
                    alert("Error al actualizar: " + data.error);
                }
            });
        });
    });
    function cancelReserv(eventId, userId, clasId, tieneInvitado, title) {
        if (confirm("¿Cancelar esta reservación?")) {
          const datos = new URLSearchParams();
          datos.append("evento", eventId);
          datos.append("usuario", userId);
          datos.append("classID", clasId);
          datos.append("title", title);
          datos.append("invitado", tieneInvitado);
      
          fetch("cancel_reserv.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            body: datos.toString()
          })
          .then(response => response.text())
          .then(data => {
           
            
                setTimeout(function() {
                    document.getElementById('eventoModal').style.display = "none";
                }, 500);
                document.getElementById('modal-content').classList.remove("Act");
               
            openCalendar();
          })
          .catch(error => {
            console.error("Error:", error);
            alert("Hubo un error al cancelar.");
          });
        }
      }
      function addInvitado(eventId, userId, clasId) {
        if (confirm("¿Deseas agregar una persona?")) {
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
                    alert("Ya no cuentas con Créditos disponibles.");
                    return; // No seguimos ejecutando el resto
                }
    
                setTimeout(function() {
                    document.getElementById('eventoModal').style.display = "none";
                }, 500);
                document.getElementById('modal-content').classList.remove("Act");
                openCalendar();
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Hubo un error al cancelar.");
            });
        }
    }
    
    function selectImage() {
        document.getElementById('imageInput').click();
      }
      
      document.getElementById('imageInput').addEventListener('change', async function() {
        if (this.files.length > 0) {
          const formData = new FormData();
          formData.append('image', this.files[0]);
      
          try {
            const response = await fetch('upload_image.php', {
              method: 'POST',
              body: formData
            });
            const result = await response.json(); 
            if (result.status === 'success') {
              location.reload(); 
            }
          } catch (error) {
            console.error('Error:', error);
            document.getElementById('result').innerText = 'Error al subir la imagen';
          }
        }
      });      
      
      