<?php

require '../Model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $relacion = $_POST['Relacion'];
    $fechaNacimiento = $_POST['FechaNacimiento'];
    $idEmpleado = $_POST['ID_Empleado'];

    $conexion = new Conexion();
    $resultado = $conexion->insertarFamiliar($nombre, $apellido, $relacion, $fechaNacimiento, $idEmpleado);

    if ($resultado) {
        echo "Familiar insertado exitosamente.";
    } else {
        echo "Error al insertar el Familiar.";
    }
}

// Incluir la vista (asegúrate de que la ruta sea correcta)
require '../Views/V_CrearFamiliar.php';


