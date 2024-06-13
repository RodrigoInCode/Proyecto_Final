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
        #simulation-area {
            border: 1px solid #ccc;
            width: 100%;
            height: 400px;
            position: relative;
            background: #e0ffe0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Asegúrate de ocultar los elementos que se salen */
        }
        #organism-panel {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }
        .organism {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        #controls {
            text-align: center;
            margin: 20px 0;
        }
        #results {
            border: 1px solid #ccc;
            padding: 20px;
            width: 100%;
            height: 100px;
            overflow-y: auto;
            background: #f9f9f9;
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
        <div id="simulation-area">
            <p>Arrastra aquí los organismos para construir tu ecosistema.</p>
        </div>
        <div id="organism-panel">
            <div class="organism" draggable="true" ondragstart="drag(event)" id="producer">Productor</div>
            <div class="organism" draggable="true" ondragstart="drag(event)" id="herbivore">Herbívoro</div>
            <div class="organism" draggable="true" ondragstart="drag(event)" id="carnivore">Carnívoro</div>
            <div class="organism" draggable="true" ondragstart="drag(event)" id="decomposer">Descomponedor</div>
        </div>
        <div id="controls">
            <button onclick="startSimulation()">Iniciar Simulación</button>
            <button onclick="resetSimulation()">Reiniciar</button>
        </div>
        <div id="results">
            <h2>Resultados y Observaciones</h2>
            <p>Aquí se mostrarán los resultados de la simulación.</p>
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

                // Inicializar velocidades aleatorias pequeñas
                this.velocityX = (Math.random() - 0.5) * 2; // Velocidad en X
                this.velocityY = (Math.random() - 0.5) * 2; // Velocidad en Y
            }

            move(containerWidth, containerHeight) {
                
                // Actualizar posiciones con velocidades
                this.x += this.velocityX;
                this.y += this.velocityY;
                console.log("X: "+this.x,"Y: "+this.y,"VelocidadX: "+this.velocityX,"VelocidadY: "+this.velocityY);
                const elementWidth = this.element.offsetWidth;
                const elementHeight = this.element.offsetHeight;

                // Rebote en los bordes del contenedor
                if (this.x < 50) {
                    this.x = 50;
                    this.velocityX = -this.velocityX-50;
                }
                if (this.y < 50) {
                    this.y = 50;
                    this.velocityY = -this.velocityY-50;
                }
                if (this.x + elementWidth+50 > containerWidth) {
                    this.x = containerWidth - elementWidth;
                    this.velocityX = -this.velocityX;
                }
                if (this.y + elementHeight-50 > containerHeight) {
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

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function drop(event) {
            event.preventDefault();
            var data = event.dataTransfer.getData("text");
            var organism = document.getElementById(data).cloneNode(true);
            organism.style.position = "absolute";

            const containerRect = event.target.getBoundingClientRect();
            const x = event.clientX - containerRect.left - 50; 
            const y = event.clientY - containerRect.top - 50; 
            console.log(containerRect);
            organism.style.left = `${x}px`;
            organism.style.top = `${y}px`;
            organism.style.transition = 'transform 1s, opacity 1s'; // Añadir transición
            event.target.appendChild(organism);

            // Añadir organismo a la simulación
            let type = data;
            let name = data.charAt(0).toUpperCase() + data.slice(1);
            ecosystem.addOrganism(new Organism(type, name, x, y, organism));
            console.log("x: "+x,"y: "+y);
        }

        function startSimulation() {
            // Iniciar la simulación
            setInterval(() => {
                ecosystem.simulateStep();
            }, 3000);
        }

        function resetSimulation() {
            // Reiniciar la simulación
            document.getElementById('simulation-area').innerHTML = "<p>Arrastra aquí los organismos para construir tu ecosistema.</p>";
            ecosystem = new Ecosystem();
            document.getElementById('results').innerHTML = "<h2>Resultados y Observaciones</h2><p>Aquí se mostrarán los resultados de la simulación.</p>";
        }

        document.getElementById('simulation-area').addEventListener('dragover', allowDrop);
        document.getElementById('simulation-area').addEventListener('drop', drop);
    </script>
</body>
</html>
