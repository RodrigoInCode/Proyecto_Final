<?php
include 'conexion.php';

$sql = "SELECT * FROM producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Devolver resultados como un array asociativo
    $productos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $productos = [];
}
?>
