
<?php
include("src\conexion.php");
if(isset($_POST['agregar'])){
    if(!$conex){
        echo "Error al conectarme al servidor";
    }else{
        $nombre = $_POST['nombre'];
        $grado = $_POST['grado']; 
        $grupo= $_POST['grupo'];
        $carrera = $_POST['carrera'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        $consulta = "INSERT INTO alumno(nombre,grado,grupo,carrera,direccion,telefono) VALUES 
        ('$nombre', '$grado', '$grupo', '$carrera', '$direccion', '$telefono')";
        $resultado = mysqli_query($conex,$consulta);
        if($resultado){
            echo "DATOS AGREGADOS";
        }else{
            echo "Error no se pudieron agregar";
        }
    }
}
?>
