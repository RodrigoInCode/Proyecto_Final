function showSection(sectionId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}
function showSection(sectionId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}

// Función para actualizar el reloj
function actualizarReloj() {
    const reloj = document.getElementById('reloj');
    const ahora = new Date();
    const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
    const fechaHora = ahora.toLocaleDateString('es-ES', opciones);
    reloj.textContent = fechaHora;
}

// Actualizar el reloj cada segundo
setInterval(actualizarReloj, 1000);

// Mostrar el reloj al cargar la página
window.onload = function() {
    actualizarReloj();
    showSection('inicio');
}
