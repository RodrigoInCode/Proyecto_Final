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
    const ahora = new Date();
    const dia = ahora.getDate();
    const mes = ahora.getMonth() + 1;
    const anio = ahora.getFullYear();
    const horas = ahora.getHours();
    const minutos = ahora.getMinutes();
    const segundos = ahora.getSeconds();

    const reloj = document.getElementById('reloj');
    reloj.innerHTML = `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
}

// Actualizar el reloj cada segundo
setInterval(actualizarReloj, 1000);



// Función para inicializar el mapa de Google Maps
function initMap() {
    const ubicacion = { lat: 19.2696887, lng: -99.6051749 }; // Ubicación seleccionada (por ejemplo, Ciudad de México)
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: ubicacion
    });
    const marker = new google.maps.Marker({
        position: ubicacion,
        map: map
    });
}
