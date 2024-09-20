<?php
require '../Model/Conexion.php';

$conexion = new Conexion();

// Estado 1: Obtener los datos del familiar a modificar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['IDFamiliar']) && !isset($_POST['modificar'])) {
    $idFamiliar = $_POST['IDFamiliar'];
    $familiar = $conexion->buscarFamiliar($idFamiliar);

    // Verifica si se encontró el familiar
    if (!$familiar) {
        die('Error: Familiar no encontrado.');
    }
}

// Estado 2: Procesar la modificación del familiar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    $idFamiliar = intval($_POST['IDFamiliar']);
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $relacion = $_POST['Relacion'];
    $fechaNacimiento = $_POST['FechaNacimiento'];
    $idEmpleado = $_POST['ID_Empleado'];

    // Modificar el familiar
    $resultado = $conexion->modificarFamiliar($idFamiliar, $nombre, $apellido, $relacion, $fechaNacimiento, $idEmpleado);

    if ($resultado) {
        echo "Familiar modificado exitosamente.";
    } else {
        echo "Error al modificar el familiar.";
    }
}

// Incluir la vista de modificación solo si los datos del familiar están disponibles
if (isset($familiar)) {
    require '../Views/V_ModFamiliar.php'; // Asegúrate de que esta ruta es correcta
}
?>
