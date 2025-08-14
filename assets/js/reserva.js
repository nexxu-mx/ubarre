'use strict';



/**
 * add event listener on multiple elements
 */

const addEventOnElements = function (elements, eventType, callback) {
  for (let i = 0, len = elements.length; i < len; i++) {
    elements[i].addEventListener(eventType, callback);
  }
}



/**
 * PRELOADER
 */

const preloader = document.querySelector("[data-preloader]");

window.addEventListener("load", function () {
  preloader.classList.add("loaded");
  document.body.classList.add("loaded");
});



/**
 * MOBILE NAVBAR
 * 
 */

const navbar = document.querySelector("[data-navbar]");
const navTogglers = document.querySelectorAll("[data-nav-toggler]");
const overlay = document.querySelector("[data-overlay]");

const toggleNav = function () {
  navbar.classList.toggle("active");
  overlay.classList.toggle("active");
  document.body.classList.toggle("nav-active");
}

addEventOnElements(navTogglers, "click", toggleNav);



/**
 * HEADER & BACK TOP BTN
 * 
 */

const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

const activeElementOnScroll = function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
    backTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    backTopBtn.classList.remove("active");
  }
}

window.addEventListener("scroll", activeElementOnScroll);



/**
 * SCROLL REVEAL
 */

const revealElements = document.querySelectorAll("[data-reveal]");

const revealElementOnScroll = function () {
  for (let i = 0, len = revealElements.length; i < len; i++) {
    if (revealElements[i].getBoundingClientRect().top < window.innerHeight / 1.15) {
      revealElements[i].classList.add("revealed");
    } else {
      revealElements[i].classList.remove("revealed");
    }
  }
}

window.addEventListener("scroll", revealElementOnScroll);

window.addEventListener("load", revealElementOnScroll);

/**
 * Change text in video section
 */

const barreTab = document.getElementById("barre");
const sculptTab = document.getElementById("sculpt");
const pilatesTab = document.getElementById("pilates");
const yogaTab = document.getElementById("yoga");
const balletTab = document.getElementById("ballet");

const textoCamb1 = document.getElementById("texto-camb-1");
const textoCamb2 = document.getElementById("texto-camb-2");
const textoCamb3 = document.getElementById("texto-camb-3");

const resetearTabsVideo = () => {
  barreTab.classList.remove("active-video");
  sculptTab.classList.remove("active-video");
  pilatesTab.classList.remove("active-video");
  yogaTab.classList.remove("active-video");
  balletTab.classList.remove("active-video");
}

const cambiarTextoVideo = (elemento) => {
  switch (elemento.id) {
    case "barre":
      resetearTabsVideo();
      textoCamb1.innerText = "Barre";
      textoCamb2.innerText = "texto2";
      textoCamb3.innerText = "texto3";
      elemento.classList.add("active-video");
      break;
    case "sculpt":
      resetearTabsVideo();
      textoCamb1.innerText = "Sculpt";
      textoCamb2.innerText = "texto2";
      textoCamb3.innerText = "texto3";
      elemento.classList.add("active-video");
      break;
    case "pilates":
      resetearTabsVideo();
      textoCamb1.innerText = "Pilates";
      textoCamb2.innerText = "texto2";
      textoCamb3.innerText = "texto3";
      elemento.classList.add("active-video");
      break;
    case "yoga":
      resetearTabsVideo();
      textoCamb1.innerText = "Yoga";
      textoCamb2.innerText = "texto2";
      textoCamb3.innerText = "texto3";
      elemento.classList.add("active-video");
      break;
    case "ballet":
      resetearTabsVideo();
      textoCamb1.innerText = "Ballet";
      textoCamb2.innerText = "texto2";
      textoCamb3.innerText = "texto3";
      elemento.classList.add("active-video");
      break;
  }

}

// Accordion functionality
var accordion = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < accordion.length; i++) {
  accordion[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
/** FUNCION LLAMADO DE CLASES */
function cargarClases(day) {
    fetch(`get_clases.php?day=${encodeURIComponent(day)}`)
        .then(response => response.json())
        .then(data => {
            const msn2 = document.getElementById("clazx");
            msn2.innerHTML = ''; // Limpia contenido anterior

            if (data.length === 0) {
                msn2.innerHTML = '<p>No hay clases para este día.</p>';
                return;
            }

            data.forEach(clase => {
                const btn = document.createElement('div');
                var reservable = '<a class="btn-reservar" style="background: #b5b5b5;">RESERVAR</a>';;
                if(clase.abierta == "1"){
                    reservable = `<a class="btn-reservar" href="#reserv" onclick="reservaClase(this)" data-nombre="${clase.nombre_coach}" data-horario="${clase.horario}" data-duracion="${clase.duracion}" data-disciplina="${clase.disciplina}" data-id="${clase.id}" data-idcoach="${clase.id_coach}">RESERVAR</a>`;
                }
                
                btn.innerHTML =  `
                    <div class="clase-container elemento-clase">
                        <div class="first-flex-clase">
                            <div class="img-clase-container">
                                <img src="assets/images/coaches/${clase.id_coach}.png" alt="Foto Coach">
                            </div>
                            <div class="nombrecoach-horarioclase">
                                <div class="nombre-coach">
                                    <p>${clase.nombre_coach}</p>
                                    <div class="detalles-clase-container">
                                        <p class="detalles-coach" onclick="mostrarModal(detallesCoachModal, ${clase.id_coach}, 1)">Detalles</p>
                                        <img src="assets/images/svg/flecha-abajo.svg" alt="Flecha abajo Ícono">
                                    </div>
                                </div>
                                <div class="horario-clase">
                                    <h3>${clase.horario}</h3>
                                    <h4>${clase.duracion}</h4>
                                    <div class="iconos-container">
                                        <div class="aforo-container">
                                            <img src="assets/images/svg/people-sharp.svg" alt="Aforo Ícono">
                                            <p>${clase.aforo}</p>
                                        </div>
                                        <div class="status-clase-icono">
                                            ${clase.estatus}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="second-flex-clase">

                            <div class="disciplina-clase-container">
                                <p>Disciplina:</p>
                                <h3>${clase.disciplina}</h3>
                                <div class="detalles-clase-disciplina-container">
                                    <p class="detalles-disciplina" onclick="mostrarModal(detallesDisciplinaModal, ${clase.id_disciplina}, 2)">Detalles</p>
                                    <img src="assets/images/svg/flecha-abajo.svg" alt="Flecha abajo Ícono">
                                </div>
                            </div>
                            <div class="btn-reservar-clase-container">
                            ${reservable}
                                
                            </div>

                        </div>
                    </div>
                `;
                msn2.appendChild(btn);
            });
        })
        .catch(error => {
            console.error("Error al obtener las clases:", error);
        });
}

/**
 * Calendar Slider
 */

window.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById("slider-container")) {
    let days = document.querySelectorAll(".calendar-slider-number");

    // Adding EventListener to Days
    days.forEach((day, index) => {
      day.addEventListener("click", () => {
        resetActiveDay();
        day.classList.add("active-day");
        numeroDiaDin.innerHTML = day.innerHTML;
        diaDin.innerHTML = textDiaSlider[index].innerHTML;
        mesDin.innerHTML = diasMes[day.innerHTML].mes;
        numeroDiaDinConf.innerHTML = day.innerHTML;
        diaDinConf.innerHTML = textDiaSlider[index].innerHTML;
        mesDinConf.innerHTML = diasMes[day.innerHTML].mes;
        
        const dayconsulta = day.innerHTML + '-' + diasMes[day.innerHTML].mes;
        cargarClases(dayconsulta);
      })
    });


    // Reset active
    const resetActiveDay = () => {
      days.forEach(day => {
        if (day.classList.contains("active-day")) {
          day.classList.remove("active-day");
        }
      });
    }

    // Dynamic date
    const diaDin = document.getElementById("texto-dia-din");
    const mesDin = document.getElementById("mes-din");
    const numeroDiaDin = document.getElementById("numero-dia-din");
    const diaDinConf = document.getElementById("texto-dia-din-conf");
    const mesDinConf = document.getElementById("mes-din-conf");
    const numeroDiaDinConf = document.getElementById("numero-dia-din-conf");
    const textDiaSlider = document.querySelectorAll(".text-day-slider");

    const hoy = new Date();

    let futuraFecha;
    let diasMes = {};
    let dia;

    days.forEach((day, index) => {
      futuraFecha = new Date(hoy);
      futuraFecha.setDate(hoy.getDate() + index);
      dia = futuraFecha.getDate();

      const diaSemana = futuraFecha.toLocaleDateString('es-ES', {
        weekday: 'long'
      });

      const mesTexto = futuraFecha.toLocaleDateString('es-ES', {
        month: 'long'
      });

      (index == 0) ? textDiaSlider[index].innerHTML = "Today" : textDiaSlider[index].innerHTML = diaSemana;
      day.innerHTML = dia;

      diasMes[dia] = { mes: mesTexto };
    });

    numeroDiaDin.innerHTML = hoy.getDate();
    mesDin.innerHTML = diasMes[hoy.getDate()].mes;
    numeroDiaDinConf.innerHTML = hoy.getDate();
    mesDinConf.innerHTML = diasMes[hoy.getDate()].mes;
    //muestra clases
    const hoyconsulta = hoy.getDate() + '-' + diasMes[hoy.getDate()].mes;
    cargarClases(hoyconsulta);
  }
});



// Playback Rate Video Footer
const videoFooter = document.getElementById("video-footer");
videoFooter.playbackRate = 2;

const videoIndexTexto = document.getElementById("video-index-texto");
/* videoIndexTexto.playbackRate = 2; */


// Details Buttons Functionality


const bgModals = document.querySelector(".bg-opacity-modals");
const detallesCoachBtn = document.querySelectorAll(".detalles-coach");
const detallesDischiplinaBtn = document.querySelectorAll(".detalles-disciplina");
const closeModalBtn = document.querySelector(".close-coach-modal-btn");
const closeDisciplinaModalBtn = document.querySelector(".close-disciplina-modal-btn");

const detallesCoachModal = document.querySelector(".modal-detalles-coach");
const detallesDisciplinaModal = document.querySelector(".modal-detalles-disciplina");



// modal detalles



closeModalBtn.addEventListener("click", () => {
  ocultarModal(detallesCoachModal, 1);
});

closeDisciplinaModalBtn.addEventListener("click", () => {
  ocultarModal(detallesDisciplinaModal, 2);
});
function mostrarModal(modal, id, tipo){
    if(tipo == 1){
        fetch("info_detalles_coach.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `id=${encodeURIComponent(id)}&tipo=${encodeURIComponent(tipo)}`
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("coach-info-img").src = data.image;
            document.getElementById("coach-info-nombre").innerHTML = data.nombre;
            document.getElementById("coach-info-descripcion").innerHTML = data.descripcion;
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }else {
            fetch("info_detalles_disciplina.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `id=${encodeURIComponent(id)}&tipo=${encodeURIComponent(tipo)}`
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("disciplina-info-nombre").innerHTML = data.nombre;
                document.getElementById("disciplina-info-descripcion").innerHTML = data.descripcion;
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
    if (window.screen.width >= 768) {
        
        modal.style.display = "block"
        modal.style.transition = "all 300ms ease-in";
        bgModals.style.display = "block";
        bgModals.style.transition = "all 500ms ease-in";
      }
      if ((screen.width >= 300 && screen.width <= 399) || (screen.width >= 400 && screen.width <= 767)) {
        modal.style.bottom = "0%";
        modal.style.display = "block"
        modal.style.transition = "all 300ms ease-in";
        bgModals.style.display = "block";
        bgModals.style.transition = "all 500ms ease-in";
      }
}


const ocultarModal = (modal, tipo) => {
  if (screen.width >= 768) {
    modal.style.display = "none";
    modal.style.transition = "all 300ms ease-in";
    bgModals.style.display = "none";
  } else {
    modal.style.bottom = "-100%";
    modal.style.transition = "all 300ms ease-in";
    bgModals.style.display = "none";
  }
  if(tipo == 1){
    document.getElementById("coach-info-img").src = "assets/images/coaches/";
    document.getElementById("coach-info-nombre").innerHTML = " ";
    document.getElementById("coach-info-descripcion").innerHTML = " ";
  }else{
    document.getElementById("disciplina-info-nombre").innerHTML = " ";
    document.getElementById("disciplina-info-descripcion").innerHTML = " ";
  }
}


/**
 * CONFIRMATION MESSAGE
 */
function reservaClase(el) {
    const confirmationSection = document.querySelector(".confirmation-section");
    const classesContainer = document.querySelector(".white-container");
    const nombre = el.dataset.nombre;
    const horario = el.dataset.horario;
    const duracion = el.dataset.duracion;
    const disciplina = el.dataset.disciplina;
    const iden = el.dataset.id;
    const idCoach = el.dataset.idcoach;
    const imag = "assets/images/coaches/" + idCoach + ".png";
    document.getElementById("confirm-coach").innerHTML = nombre;
    document.getElementById("confirm-horario").innerHTML = horario;
    document.getElementById("confirm-duracion").innerHTML = duracion;
    document.getElementById("confirm-disciplina").innerHTML = disciplina;
    document.getElementById("confirm-coach-img").src = imag;
    document.getElementById("confirm-agendar").dataset.id = iden;
    confirmationSection.style.display = 'block';
    classesContainer.style.display = 'none';
}
function cancelConfirmacion() {
   document.querySelector(".confirmation-section").style.display = 'none';
   document.querySelector(".white-container").style.display = 'block';
   document.getElementById("confirm-coach").innerHTML = " ";
   document.getElementById("confirm-horario").innerHTML = " ";
   document.getElementById("confirm-duracion").innerHTML = " ";
   document.getElementById("confirm-disciplina").innerHTML = " ";
   document.getElementById("confirm-coach-img").src = "assets/images/coaches/unknnow.png";
   document.getElementById("confirm-agendar").dataset.id = " ";
}
function usrInf() {
    fetch("get_user_info.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            var datosUsuario = data.nombre + " | " + data.credit + " Créditos"
            document.getElementById("my-account").innerHTML = datosUsuario;
        })
        .catch(error => console.error("Error al obtener los datos:", error));
}
if (document.getElementById("my-account")) {
    usrInf();
}
/**
 * LOGIN
 */

function openRegistro() {
  document.getElementById('loginForm').style.display = 'none';
  document.getElementById('registro').style.display = 'block';
}
function closeRegistro() {
  document.getElementById('loginForm').style.display = 'block';
  document.getElementById('registro').style.display = 'none';
}
if (document.getElementById('loginForm')) {

}


