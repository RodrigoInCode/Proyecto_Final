function loadContent(url) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function() {
        console.log(xhr.readyState); // Agregamos este console.log()
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Agregamos este console.log()
            document.getElementById('main-content').innerHTML = xhr.responseText;
            if (url === 'nosotros.html') {
                initMap();
            }
        }
    };
    xhr.send();
}


// Función para inicializar el mapa de Google Maps
function initMap() {
    const ubicacion = { lat: 19.432608, lng: -99.133209 }; // Ubicación personalizada
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: ubicacion
    });
    const marker = new google.maps.Marker({
        position: ubicacion,
        map: map
    });
}

// Función para actualizar el reloj en tiempo real
function updateClock() {
    const now = new Date();
    const reloj = document.getElementById('reloj');
    if (reloj) {
        reloj.innerHTML = now.toLocaleTimeString();
    }
    setTimeout(updateClock, 1000);
}

// Evento que se dispara cuando la página está completamente cargada
document.addEventListener('DOMContentLoaded', function() {
    // Cargar la sección de inicio al cargar la página
    loadContent('inicio.html');
    // Actualizar el reloj en tiempo real
    updateClock();
});

// Evento para cargar las secciones al hacer clic en los elementos del menú
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('menu-item')) {
        const sectionName = event.target.dataset.section;
        loadContent(sectionName + '.html');
    }
});
