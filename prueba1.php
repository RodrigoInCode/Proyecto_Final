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
            organism.style.left = (event.clientX - event.target.getBoundingClientRect().left - 50) + 'px';
            organism.style.top = (event.clientY - event.target.getBoundingClientRect().top - 50) + 'px';
            event.target.appendChild(organism);
        }

        function startSimulation() {
            // Lógica para iniciar la simulación
            document.getElementById('results').innerHTML += "<p>Simulación iniciada...</p>";
        }

        function resetSimulation() {
            // Lógica para reiniciar la simulación
            document.getElementById('simulation-area').innerHTML = "<p>Arrastra aquí los organismos para construir tu ecosistema.</p>";
            document.getElementById('results').innerHTML = "<p>Aquí se mostrarán los resultados de la simulación.</p>";
        }

        document.getElementById('simulation-area').addEventListener('dragover', allowDrop);
        document.getElementById('simulation-area').addEventListener('drop', drop);
    </script>
</body>
</html>
