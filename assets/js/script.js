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
function hidePreloader() {
  preloader.classList.add("loaded");
  document.body.classList.add("loaded");
}
window.addEventListener("load", hidePreloader);
setTimeout(hidePreloader, 1500);



/**
 * MOBILE NAVBAR
 * 
 */

const navbar = document.querySelector("[data-navbar]");
const navTogglers = document.querySelectorAll("[data-nav-toggler]");
const overlay = document.querySelector("[data-overlay]");
const mobileNavBar = document.getElementById('header-mobile');

window.addEventListener('DOMContentLoaded', () => {
  if (screenTop == 0) {
    mobileNavBar.classList.add("active");
  }
});

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
 * SCROLL mobile
 */
let lastScrollTop = 0;

window.addEventListener("scroll", function () {
  const headerMob = document.getElementById("header-mobile");
  const currentScroll = window.scrollY || document.documentElement.scrollTop;

  if (currentScroll === 0) {
    headerMob.classList.add("active");
  } else if (currentScroll < lastScrollTop) {
    headerMob.classList.add("active");
  } else {
    headerMob.classList.remove("active");
  }
  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
}, { passive: true });

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
        var reservable = '<a class="btn-rcoloresCoaches[index]eservar" style="color: #747373;">RESERVAR</a>';;
        if (clase.abierta == "1") {

          reservable = `<p class="btn-bebida" href=""
                onclick="handleReserva(event)"
                data-nombre="${clase.nombre_coach}" 
                data-horario="${clase.horario}" 
                data-duracion="${clase.duracion}" 
                data-disciplina="${clase.disciplina}" 
                data-iddisciplina="${clase.id_disciplina}" 
                data-id="${clase.id}" 
                data-idcoach="${clase.id_coach}">
                RESERVAR
             </p>`;

        }

        btn.innerHTML = `
                  <div class="clase-container elemento-clase">
                      <div class="first-flex-clase">
                          <div class="img-clase-container">
                              <img src="assets/images/coaches/pro/${clase.id_coach}.png" alt="Foto Coach">
                          </div>
                          <div class="nombrecoach-horarioclase">
                              <div class="nombre-coach">
                                  <p>${clase.nombre_coach}</p>
                                  <div class="detalles-clase-container">
                                      <p class="detalles-coach" onclick="mostrarModal(detallesCoachModal, ${clase.id_coach}, 1, event)">Detalles</p>
                                      <img src="assets/images/svg/flecha-abajo.svg" alt="Flecha abajo Ícono">
                                  </div>
                              </div>
                              <div class="horario-clase">
                                  <h3>POWER ${clase.disciplina}</h3>
                                  <h3>${clase.horario}</h3>
                                  <h4>${clase.duracion}</h4>
                              </div>
                          </div>

                      </div>
                      <div class="second-flex-clase">

                          <div class="disciplina-clase-container">
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

      (index == 0) ? textDiaSlider[index].innerHTML = "Hoy" : textDiaSlider[index].innerHTML = diaSemana;
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

// Establecer colores de las disciplinas en clases.php
const colores = [
  "var(--danyfer-karina-color)",
  "var(--maria-color)",
  "var(--light-brown-3)",
  "var(--danyfer-karina-color)",
  "var(--maria-color)"
];

const disciplinas = document.querySelectorAll(".color-class");


if (disciplinas.length > 0) {
  disciplinas.forEach((disciplina, index) => {
    if (index < colores.length) {
      (colores[index] != "var(--light-brown-3)") ? disciplina.style.color = "var(--light-brown)" : disciplina.style.color = "var(--danyfer-karina-color)";
      disciplina.style.backgroundColor = colores[index];
    }
  });
}
const videos = document.querySelectorAll('video[data-reveal-videos-disciplines]');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    const video = entry.target;
    if (entry.isIntersecting) {
      video.play();
    } else {
      video.pause();
    }
  });
}, {
  threshold: 0.5 // El video debe estar al menos 50% visible para reproducirse
});

videos.forEach(video => observer.observe(video));
// Establecer colores de los coaches en coaches.php
const coloresCoaches = [
  "var(--maria-color)",
  "var(--katya-cons-color)",
  "var(--gali-color)",
  "var(--regina-ivanna-color)",
  "var(--danyfer-karina-color)",
  "var(--katya-cons-color)",
  "var(--regina-ivanna-color)",
  "var(--beto-color)",
  "var(--danyfer-karina-color)",
];

const coaches = document.querySelectorAll('.color-coach');
const disciplineCoachTexts = document.querySelectorAll(".discipline-coach");

if (coaches.length > 0) {
  coaches.forEach((coach, index) => {
    disciplineCoachTexts[index].style.transition = "all 500ms ease";
    if (index < coloresCoaches.length) {
      if (coloresCoaches[index] != "var(--katya-cons-color)" &&
        coloresCoaches[index] != "var(--gali-color)" &&
        coloresCoaches[index] != "var(--regina-ivanna-color)" &&
        coloresCoaches[index] != "var(--beto-color)") {
        coach.style.color = "var(--light-brown)";
        disciplineCoachTexts[index].addEventListener('mouseenter', () => {
          disciplineCoachTexts[index].style.backgroundColor = 'var(--light-brown)';
          disciplineCoachTexts[index].style.color = coloresCoaches[index];
        });
        disciplineCoachTexts[index].addEventListener('mouseout', () => {
          disciplineCoachTexts[index].style.backgroundColor = 'transparent';
          disciplineCoachTexts[index].style.color = 'var(--light-brown)';
        });
      }
      else {
        coach.style.color = "var(--danyfer-karina-color)";
        disciplineCoachTexts[index].style.borderColor = 'var(--danyfer-karina-color)';
        disciplineCoachTexts[index].addEventListener('mouseenter', () => {
          disciplineCoachTexts[index].style.backgroundColor = 'var(--danyfer-karina-color)';
          disciplineCoachTexts[index].style.color = coloresCoaches[index];
        });
        disciplineCoachTexts[index].addEventListener('mouseout', () => {
          disciplineCoachTexts[index].style.backgroundColor = 'transparent';
          disciplineCoachTexts[index].style.color = 'var(--danyfer-karina-color)';
        });
      }
      coach.style.backgroundColor = coloresCoaches[index];
    }
  });
}

/**
 * SCROLL REVEAL
 */

const revealVideosDisciplines = document.querySelectorAll("[data-reveal-videos-disciplines]");

const revealVideosDisciplinesOnScroll = function () {
  for (let i = 0, len = revealVideosDisciplines.length; i < len; i++) {
    if (revealVideosDisciplines[i].getBoundingClientRect().top < window.innerHeight / 1.15) {
      revealVideosDisciplines[i].setAttribute('autoplay', null);
      revealVideosDisciplines[i].setAttribute('muted', null);
      revealVideosDisciplines[i].setAttribute('loop', null);
    } else {
      revealVideosDisciplines[i].removeAttribute('autoplay');
      revealVideosDisciplines[i].removeAttribute('muted');
      revealVideosDisciplines[i].removeAttribute('loop');
    }
  }
}

window.addEventListener("scroll", revealVideosDisciplinesOnScroll);

window.addEventListener("load", revealVideosDisciplinesOnScroll);

// Dialog mobile functionality

const dialog = document.querySelector("dialog");
let hintDialogBtn = document.getElementById("hint-icon");
let closeDialogBtn = document.getElementById("close-dialog-btn");

if (hintDialogBtn == null) { hintDialogBtn = 0; }
if (closeDialogBtn == null) { closeDialogBtn = 0; }

if (hintDialogBtn != 0) {
  hintDialogBtn.addEventListener("click", () => {
    dialog.removeAttribute('close');
    dialog.setAttribute('open', null);
  });
}

if (closeDialogBtn != 0) {
  closeDialogBtn.addEventListener('click', () => {
    dialog.removeAttribute('open');
    dialog.setAttribute('close', null);
  });
}


// Details Buttons Functionality


const bgModals = document.querySelector(".bg-opacity-modals");
const detallesCoachBtn = document.querySelectorAll(".detalles-coach");
const detallesDischiplinaBtn = document.querySelectorAll(".detalles-disciplina");
let closeModalBtn = document.querySelector(".close-coach-modal-btn");
if (closeModalBtn == null) { closeModalBtn = 0; }
let closeDisciplinaModalBtn = document.querySelector(".close-disciplina-modal-btn");
if (closeDisciplinaModalBtn == null) { closeDisciplinaModalBtn = 0; }

const detallesCoachModal = document.querySelector(".modal-detalles-coach");
const detallesDisciplinaModal = document.querySelector(".modal-detalles-disciplina");



// modal detalles


if (closeModalBtn != 0) {
  closeModalBtn.addEventListener("click", () => {
    ocultarModal(detallesCoachModal, 1);
  });
}

if (closeDisciplinaModalBtn != 0) {
  closeDisciplinaModalBtn.addEventListener("click", () => {
    ocultarModal(detallesDisciplinaModal, 2);
  });
}

if (document.querySelector(".modal-detalles-coach")) {
  const modalCoach = document.querySelector(".modal-detalles-coach");

  function mostrarModal(modal, id, tipo, event) {
    if (tipo == 1) {
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
        .catch(error => console.error("Error:", error));
    } else {
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
        .catch(error => console.error("Error:", error));
    }

    const boton = event.currentTarget;
    const rect = boton.getBoundingClientRect();

    modal.style.position = "absolute";

    if (window.innerWidth <= 768) {
      modal.style.top = `${rect.bottom + window.scrollY + 10}px`;
      modal.style.left = `${rect.left}px`;
    } else {
      modal.style.top = `${rect.bottom + window.scrollY + 250}px`;
      modal.style.left = `${rect.left + window.scrollX}px`;
    }


    modal.style.display = "block";
    modal.classList.add("show");
  }


  function ocultarModal(modal, tipo) {
    modal.classList.remove("show");
    setTimeout(() => modal.style.display = "none", 200);

    if (tipo == 1) {
      document.getElementById("coach-info-img").src = "";
      document.getElementById("coach-info-nombre").innerHTML = "";
      document.getElementById("coach-info-descripcion").innerHTML = "";
    } else {
      document.getElementById("disciplina-info-nombre").innerHTML = "";
      document.getElementById("disciplina-info-descripcion").innerHTML = "";
    }
  }

  document.addEventListener("click", (e) => {
    if (modalCoach.style.display === "block") {
      const isClickInside = modalCoach.contains(e.target) || e.target.classList.contains("detalles-coach");
      if (!isClickInside) {
        ocultarModal(modalCoach, 1);
      }
    }
  });

}

let detallesBebidaModal

if (document.querySelector(".modal-detalles-bebida")) {
  detallesBebidaModal = document.querySelector(".modal-detalles-bebida");
  let closeBebidaModalBtn = document.querySelector(".close-bebida-modal-btn");
  if (closeBebidaModalBtn == null) { closeBebidaModalBtn = 0; }


  function ocultarModalBebida() {
    detallesBebidaModal.classList.remove("show");
    setTimeout(() => detallesBebidaModal.style.display = "none", 200);
  }

  if (closeBebidaModalBtn != 0) {
    closeBebidaModalBtn.addEventListener("click", () => {
      ocultarModalBebida();
    });
  }


  document.addEventListener("click", (e) => {
    if (detallesBebidaModal.style.display === "block") {
      const isClickInside = detallesBebidaModal.contains(e.target) || e.target.classList.contains("btn-bebida");
      if (!isClickInside) {
        ocultarModalBebida();
      }
    }
  });

}

function mostrarModalBebida(event) {
  event.preventDefault();

  const boton = event.currentTarget;
  const rect = boton.getBoundingClientRect();

  detallesBebidaModal.style.position = "absolute";

  if (window.innerWidth <= 768) {
    detallesBebidaModal.style.top = `${rect.bottom + window.scrollY - 200}px`;
    detallesBebidaModal.style.left = `${rect.left - 70}px`;
  } else {
    detallesBebidaModal.style.top = `${rect.bottom + window.scrollY - 200}px`;
    detallesBebidaModal.style.left = `${rect.left + window.scrollX - 250}px`;
  }

  /* Aqui se hará la validación */
  detallesBebidaModal.style.display = "block";

  detallesBebidaModal.classList.add("show");

  const btnsAgregar = detallesBebidaModal.querySelectorAll(".btn-confirmar-bebida a");

  btnsAgregar.forEach(btn => {
    btn.dataset.nombre = boton.dataset.nombre;
    btn.dataset.horario = boton.dataset.horario;
    btn.dataset.duracion = boton.dataset.duracion;
    btn.dataset.disciplina = boton.dataset.disciplina;
    btn.dataset.id = boton.dataset.id;
    btn.dataset.idcoach = boton.dataset.idcoach;

    btn.dataset.bebida = "Sin bebida";
    btn.dataset.momento = "Al final de la clase";
  });
}

//Nueva función que determina si se usa mostrarModalBebida o se pasa directo a reservaClase
function handleReserva(event) {
  event.preventDefault();
  const boton = event.currentTarget || event.target;

  const total = (typeof userTotalSmoothies !== 'undefined') ? Number(userTotalSmoothies) : 0;
  /*  console.log("handleReserva total_smoothies:", total); */

  if (total > 0) {
    //Usuario con smoothieS: sigue flujo normal
    mostrarModalBebida(event);
  } else {
    //Usuario con 0 smoothies: salta directo al contenedor resumen
    reservaClase(boton);
  }
}


/**
 * CONFIRMATION MESSAGE
 */
function reservaClase(el) {
  const confirmationSection = document.querySelector(".confirmation-section");
  const classesContainer = document.querySelector(".contenido-seleccion-clase");
  const modalVisible = document.querySelector(".modal-detalles-bebida");

  const slide = el ? el.closest(".slide-bebida") : null;
  let bebida = "";
  let momento = "Al final de la clase";

  if (slide) {
    bebida = slide.dataset.bebida || "";
    const toggle = slide.querySelector(".dropdown-toggle");
    momento = (toggle && toggle.textContent.trim()) || "Al final de la clase";
    if (momento === "Sin smoothie") bebida = "";
  } else {
    // Viene directo del botón RESERVAR (flujo con 0 smoothies)
    bebida = el.dataset.bebida || "";
    momento = el.dataset.momento || "Sin Smoothie";
  }

  const nombre = el.dataset.nombre;
  const horario = el.dataset.horario;
  const duracion = el.dataset.duracion;
  const disciplina = el.dataset.disciplina;
  const iden = el.dataset.id;
  const idCoach = el.dataset.idcoach;
  const imag = "assets/images/coaches/pro/" + idCoach + ".png";

  document.getElementById("confirm-coach").innerHTML = nombre;
  document.getElementById("confirm-horario").innerHTML = horario;
  document.getElementById("confirm-duracion").innerHTML = duracion;
  document.getElementById("confirm-disciplina").innerHTML = disciplina;
  document.getElementById("confirm-coach-img").src = imag;

  if (!bebida || momento === "Sin Smoothie") {
    document.getElementById("confirm-bebida").textContent = "";
    document.getElementById("confirm-momento").textContent = "Sin Smoothie";
  } else {
    document.getElementById("confirm-bebida").textContent = bebida;
    document.getElementById("confirm-momento").textContent = momento;
  }

  document.getElementById("confirm-agendar").dataset.id = iden;
  document.getElementById("confirm-agendar").dataset.coach = nombre;
  document.getElementById("confirm-agendar").dataset.disciplina = disciplina;
  document.getElementById("confirm-agendar").dataset.duracion = duracion;
  document.getElementById("confirm-agendar").dataset.id_inst = idCoach;
  document.getElementById("confirm-agendar").dataset.bebida = bebida || "";
  document.getElementById("confirm-agendar").dataset.momento = (momento === "Sin Smoothie") ? "Sin Smoothie" : momento;

  // Mostrar confirmación y ocultar lo demás
  confirmationSection.style.display = 'block';
  classesContainer.style.display = 'none';
  if (modalVisible) modalVisible.style.display = 'none';
}

function confirmacion(el) {
  const idClas = el.dataset.id;
  const ncoach = el.dataset.coach;
  const ndisciplina = el.dataset.disciplina;
  const durac = el.dataset.duracion;
  const idcoach = el.dataset.id_inst;
  const bebida = el.dataset.bebida;
  const momento = el.dataset.momento;

  fetch('registrar_reservacion.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      idClas: idClas,
      ncoach: ncoach,
      ndisciplina: ndisciplina,
      durac: durac,
      idcoach: idcoach,
      bebida: bebida,
      momento: momento
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        window.location.href = 'profile.php?set=reservaciones';
      } else if (data.status === 'nocredit') {
        document.getElementById('confirm-class').innerHTML = `
          <h2>Se acabaron tus créditos</h2>
          <div style="display: flex;flex-direction: column;align-items: center;gap: 30px;">
          <img src="assets/images/wait.svg" style="width: 100px" alt="">
          <p>Para seguir reservando tus clases, por favor adquiere nuevos créditos.</p>
          <a href="paquetes.php" class="confirmar-reserva-btn">Ver Paquetes</a>
          </div>`;

      } else if (data.status === 'nosession') {
        window.location.href = 'profile.php';
      }
      else {
        alert('Error al registrar reservación');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      /* alert('Hubo un problema al registrar.'); */
      window.location.href = 'profile.php';
    });
}

function cancelConfirmacion() {
  document.querySelector(".confirmation-section").style.display = 'none';
  document.querySelector(".contenido-seleccion-clase").style.display = 'block';
  document.getElementById("confirm-coach").innerHTML = " ";
  document.getElementById("confirm-horario").innerHTML = " ";
  document.getElementById("confirm-duracion").innerHTML = " ";
  document.getElementById("confirm-disciplina").innerHTML = " ";
  document.getElementById("confirm-coach-img").src = "assets/images/coaches/pro/unknnow.png";
  document.getElementById("confirm-agendar").dataset.id = " ";
}

//Variable global para almacenar total_smoothies (Usamos el valor que viene de reserva.php)
let userTotalSmoothies = (typeof window.userTotalSmoothies !== 'undefined') ? Number(window.userTotalSmoothies) : 0;

function usrInf() {
  fetch("get_user_info.php")
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
        return;
      }

      //Actualizar la variables global con total_smoothies
      userTotalSmoothies = data.total_smoothies || 0;
      var datosUsuario = data.nombre + " | " + data.credit + " Créditos"

      if (document.getElementById("my-account")) {
        document.getElementById("my-account").innerHTML = datosUsuario;
      }

      if (typeof cargarSmoothies === 'function') {
        cargarSmoothies();
      }
    })
    .catch(error => console.error("Error al obtener los datos:", error));
}


if (document.getElementById("my-account")) {
  usrInf();
}

/* console.log(userTotalSmoothies) */

/**
 * LOGIN
 */

function openRegistro() {
  document.getElementById('loginForm').style.display = 'none';
  document.getElementById('registro').style.display = 'block';
}
function openCo() {
  document.getElementById('loginForm').style.display = 'none';
  document.getElementById('contraseña').style.display = 'block';
}
function closeRegistro() {
  document.getElementById('loginForm').style.display = 'block';
  document.getElementById('registro').style.display = 'none';
}
function closeCo() {
  document.getElementById('loginForm').style.display = 'block';
  document.getElementById('contraseña').style.display = 'none';
}
if (document.getElementById('loginForm')) {

}



/**
 * INDEX COACHES SLIDER
 */

let slider = document.getElementById('slider');
if (slider == null) { slider = 0; }
let slides;
if (slider != 0) { slides = slider.querySelectorAll('.slide'); }
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');

if (slider != 0) {
  // Cambiar el índice inicial a 3 (cuarto elemento)
  let currentIndex = 3;

  function scrollToIndex(index) {
    const slideWidth = slides[0].offsetWidth;
    const offset = index * slideWidth;
    slider.scrollTo({ left: offset, behavior: 'smooth' });
    highlightCenter(index);
  }

  function detectCenter() {
    const sliderRect = slider.getBoundingClientRect();
    const centerX = sliderRect.left + sliderRect.width / 2;
    let closest = null;
    let closestDist = Infinity;

    slides.forEach((slide, i) => {
      const slideRect = slide.getBoundingClientRect();
      const slideCenter = slideRect.left + slideRect.width / 2;
      const dist = Math.abs(slideCenter - centerX);
      if (dist < closestDist) {
        closestDist = dist;
        closest = i;
      }
    });

    currentIndex = closest;
    highlightCenter(currentIndex);

    const centerSlide = slides[currentIndex];

    const slideDiscipline = centerSlide ? centerSlide.getAttribute('data-disciplina') : '';

    // Mostrar la disciplina en el cuadro de abajo
    const displayBox = document.querySelector('.coaches-slider-discipline');
    if (displayBox) {
      displayBox.textContent = slideDiscipline;
    }
  }

  function highlightCenter(index) {
    slides.forEach(slide => slide.classList.remove('center'));
    if (slides[index]) {
      slides[index].classList.add('center');
    }
  }

  slider.addEventListener('scroll', () => {
    clearTimeout(slider._timeout);
    slider._timeout = setTimeout(detectCenter, 100);
  });

  prevBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
      currentIndex--;
      scrollToIndex(currentIndex);
    }
  });

  nextBtn.addEventListener('click', () => {
    if (currentIndex < slides.length - 1) {
      currentIndex++;
      scrollToIndex(currentIndex);
    }
  });

  // Asegurarse de que se desplace al cuarto elemento al cargar
  window.addEventListener('load', () => scrollToIndex(currentIndex));
  window.addEventListener('resize', () => scrollToIndex(currentIndex));
}

//Función para mostrar los smoothies

//Inicializar slider de smoothies

function initSlider() {
  const slider = document.querySelector('.container-slider-bebidas');
  if (!slider) return; // seguridad por si no existe

  const slides = slider.querySelectorAll('.slide-bebida');
  const prevBtn = slider.querySelector('.flecha-slider-izquierda button');
  const nextBtn = slider.querySelector('.flecha-slider-derecha button');

  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.display = i === index ? 'block' : 'none';
    });
  }

  showSlide(currentIndex);

  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  });

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  });
}

//Cargar smoothies dinámicamente

function cargarSmoothies() {
  fetch("get_smoothies.php")
    .then(response => response.json())
    .then(data => {
      if (document.getElementById("smoothie-slides")) {
        const slidesWrapper = document.getElementById("smoothie-slides");

        /* //Verificar si el contenedor existe, estos es si total_smoothies > 0
        if (!slidesWrapper) {
          console.log("Usuario no tiene Smoothies disponibles");
          return;
        } */

        slidesWrapper.innerHTML = "";

        data.forEach(smoothie => {
          const slide = document.createElement("div");
          slide.classList.add("slide-bebida");
          slide.dataset.bebida = smoothie.sabor;

          slide.innerHTML = `
          <div>
            <img src="${smoothie.ruta}" alt="${smoothie.sabor}">
          </div>
          <div>
            <h3>Agregar Smoothie</h3>
            <p>Proteína ${smoothie.sabor}</p>
            
          <div class="dropdown">
            <div class="dropdown-toggle">Al final de la clase
            </div>
            <ul class="dropdown-menu menu-bebidas">
              <li>Al final de la clase</li>
              <li>Al inicio de la clase</li>
              <li>Sin smoothie</li>
            </ul>
            </div>
          </div>

          <div class="smoothies-disponibles">
            <small>${userTotalSmoothies} smoothies disponibles aún</small>
          </div>

          <div class="botones-bebida">
            <button class="close-bebida-modal-btn">CANCELAR</button>
            <div class="btn-confirmar-bebida">
              <a href="#reserv" onclick="reservaClase(this)">AGREGAR</a>
            </div>
          </div>
        `;
          slidesWrapper.appendChild(slide);
        });

        //Ahora que ya están creados los slides, inicializamos el slider
        initSlider();
      }
    })
    .catch(error => console.error("Error cargando smoothies:", error));
}

// Ejecutar cuando cargue la página
document.addEventListener("DOMContentLoaded", cargarSmoothies);

//Evento para desplegar las opciones del momento 

document.addEventListener('click', function (e) {
  const toggle = e.target.closest('.dropdown-toggle');
  const option = e.target.closest('.menu-bebidas li');

  // Cierra todos los dropdowns si haces clic fuera
  document.querySelectorAll('.dropdown').forEach(d => {
    d.classList.remove('open');
  });

  // Abrir el dropdown si se hace clic en el toggle
  if (toggle) {
    const dropdown = toggle.closest('.dropdown');
    dropdown.classList.toggle('open');
    return; // Salimos para evitar que se cierre inmediatamente
  }

  // Seleccionar opción si se hace clic en un <li>
  if (option) {
    const dropdown = option.closest('.dropdown');
    const toggle = dropdown.querySelector('.dropdown-toggle');
    toggle.textContent = option.textContent;
    dropdown.classList.remove('open');

    // (Opcional) Guardar el valor en un input hidden
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    if (hiddenInput) {
      hiddenInput.value = option.textContent;
    }
  }
});