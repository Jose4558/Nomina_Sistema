<?php

require '../Model/Conexion.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion = new Conexion();
    $conexion->eliminarEmpleado($id);
    header("Location: lista_empleados.php");
}

?>