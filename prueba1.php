<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio Virtual - Redes Tróficas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        #header {
            text-align: center;
            margin-top: 20px;
        }
        #theory {
            margin: 20px 0;
        }
        #simulation-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        #results {
            border: 1px solid #ccc;
            padding: 20px;
            width: 100%;
            height: 100px;
            overflow-y: auto;
            background: #f9f9f9;
            margin-bottom: 20px;
        }
        #simulation-container {
    display: flex;
    flex-direction: row-reverse; /* Cambiado a row-reverse */
    width: 100%;
        }
     #simulation-area {
            border: 1px solid #ccc;
            width: 100%;
            height: 700px;
            position: relative;
            background: #e0ffe0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        #organism-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100px;
    margin-right: 50px; /* Aumenta el margen derecho para mover el panel hacia atrás */
}
        .organism {
    width: 100%;
    height: 100px;
    border: 1px solid #000;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin-bottom: 20px; /* Aumenta el margen inferior entre los organismos */
}
        #controls {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="header">
            <h1>Laboratorio Virtual - Redes Tróficas</h1>
        </div>
        <div id="theory">
            <h2>Conceptos Teóricos</h2>
            <p>Las redes tróficas representan las relaciones de alimentación entre los diferentes organismos en un ecosistema...</p>
        </div>
        <div id="simulation-wrapper">
            <div id="results">
                <h2>Resultados y Observaciones</h2>
                <p>Aquí se mostrarán los resultados de la simulación.</p>
            </div>
            <div id="simulation-container">
                <div id="simulation-area">
                    <p>Arrastra aquí los organismos para construir tu ecosistema.</p>
                </div>
                <div id="organism-panel">
                    <div class="organism" draggable="true" ondragstart="drag(event)" id="producer">Productor</div>
                    <div class="organism" draggable="true" ondragstart="drag(event)" id="herbivore">Herbívoro</div>
                    <div class="organism" draggable="true" ondragstart="drag(event)" id="carnivore">Carnívoro</div>
                    <div class="organism" draggable="true" ondragstart="drag(event)" id="decomposer">Descomponedor</div>
                </div>
            </div>
        </div>
        <div id="controls">
            <button onclick="startSimulation()">Iniciar Simulación</button>
            <button onclick="resetSimulation()">Reiniciar</button>
        </div>
    </div>

    <script>
        class Organism {
            constructor(type, name, x, y, element) {
                this.type = type;
                this.name = name;
                this.x = x;
                this.y = y;
                this.element = element;
                this.energy = 100;

                // Inicializar velocidades más pequeñas
                this.velocityX = (Math.random() - 0.5) * 0.2; // Reducir el rango de velocidad en X
                this.velocityY = (Math.random() - 0.5) * 0.2; // Reducir el rango de velocidad en Y
            }

            move(containerWidth, containerHeight) {
                // Actualizar posiciones con velocidades
                this.x += this.velocityX;
                this.y += this.velocityY;

                const elementWidth = this.element.offsetWidth;
                const elementHeight = this.element.offsetHeight;

                // Rebote en los bordes del contenedor
                if (this.x < 0) {
                    this.x = 0;
                    this.velocityX = -this.velocityX;
                }
                if (this.y < 0) {
                    this.y = 0;
                    this.velocityY = -this.velocityY;
                }
                if (this.x + elementWidth > containerWidth) {
                    this.x = containerWidth - elementWidth;
                    this.velocityX = -this.velocityX;
                }
                if (this.y + elementHeight > containerHeight) {
                    this.y = containerHeight - elementHeight;
                    this.velocityY = -this.velocityY;
                }

                // Aplicar movimiento al elemento HTML
                this.element.style.transform = `translate(${this.x}px, ${this.y}px)`;
            }

            updateEnergy(amount) {
                this.energy += amount;
                if (this.energy <= 0) {
                    this.die();
                }
            }

            die() {
                this.element.style.opacity = 0;
                setTimeout(() => {
                    this.element.remove();
                }, 1000);
            }
        }

        class Ecosystem {
            constructor() {
                this.organisms = [];
                this.container = document.getElementById('simulation-area');
                this.containerWidth = this.container.clientWidth;
                this.containerHeight = this.container.clientHeight;

                window.addEventListener('resize', () => {
                    this.containerWidth = this.container.clientWidth;
                    this.containerHeight = this.container.clientHeight;
                });
            }

            addOrganism(organism) {
                this.organisms.push(organism);
            }

            simulateStep() {
                this.organisms.forEach(org => {
                    org.move(this.containerWidth, this.containerHeight);
                    // Aquí agregar lógica específica de interacciones tróficas
                });

                this.updateResults();
            }

            updateResults() {
                const results = document.getElementById('results');
                results.innerHTML = `<h2>Resultados y Observaciones</h2>`;
                const types = this.organisms.reduce((acc, org) => {
                    acc[org.type] = (acc[org.type] || 0) + 1;
                    return acc;
                }, {});
                for (const type in types) {
                    results.innerHTML += `<p>${type.charAt(0).toUpperCase() + type.slice(1)}s: ${types[type]}</p>`;
                }
            }
        }

        let ecosystem = new Ecosystem();
        let simulationRunning = false;
        let simulationInterval = null; // Para almacenar el intervalo de la simulación

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function drop(event) {
    event.preventDefault();
    const data = event.dataTransfer.getData("text");
    const originalOrganism = document.getElementById(data);
    const organism = originalOrganism.cloneNode(true);
    organism.style.position = "absolute";

    const containerRect = event.target.getBoundingClientRect();
    const elementWidth = originalOrganism.offsetWidth;
    const elementHeight = originalOrganism.offsetHeight;

    // Calcular la posición inicial dentro del área visible del contenedor
    let x = event.clientX - containerRect.left - (elementWidth / 2);
    let y = event.clientY - containerRect.top - (elementHeight / 2);

    // Ajustar la posición inicial para que esté dentro de los límites del contenedor
    x = Math.max(0, Math.min(x, containerRect.width - elementWidth));
    y = Math.max(0, Math.min(y, containerRect.height - elementHeight));

    organism.style.left = `${x}px`;
    organism.style.top = `${y}px`;
    organism.style.width = `${elementWidth}px`; // Asegurar que el tamaño sea igual al original
    organism.style.height = `${elementHeight}px`; // Asegurar que el tamaño sea igual al original
    organism.style.transition = 'transform 1s, opacity 1s'; // Añadir transición
    event.target.appendChild(organism);

    // Añadir organismo a la simulación
    let type = data;
    let name = data.charAt(0).toUpperCase() + data.slice(1);
    ecosystem.addOrganism(new Organism(type, name, x, y, organism));
}
        function startSimulation() {
            // Iniciar la simulación solo si no está corriendo actualmente
            if (!simulationRunning) {
                simulationRunning = true;
                simulationInterval = setInterval(() => {
                    ecosystem.simulateStep();
                }, 100); // Intervalo reducido a 100ms para movimientos más frecuentes
            }
        }

        function resetSimulation() {
            // Detener la simulación si está activa
            if (simulationInterval !== null) {
                clearInterval(simulationInterval);
                simulationInterval = null;
            }

            // Reiniciar el área de simulación y el ecosistema
            document.getElementById('simulation-area').innerHTML = "<p>Arrastra aquí los organismos para construir tu ecosistema.</p>";
            ecosystem = new Ecosystem();
            document.getElementById('results').innerHTML = "<h2>Resultados y Observaciones</h2><p>Aquí se mostrarán los resultados de la simulación.</p>";

            // Establecer la bandera de simulación a false
            simulationRunning = false;
        }

        document.getElementById('simulation-area').addEventListener('dragover', allowDrop);
        document.getElementById('simulation-area').addEventListener('drop', drop);
    </script>
</body>
</html>
