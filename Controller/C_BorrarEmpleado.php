<?php

require '../Model/Conexion.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se ha enviado el ID_Empleado
    $ID_Empleado = isset($_POST['ID_Empleado']) ? intval($_POST['ID_Empleado']) : null;

    if ($ID_Empleado !== null) {
        // Instancia de la conexión
        $conexion = new Conexion();

        // Llamar a la función para borrar un empleado
        $resultado = $conexion->borrarEmpleado($ID_Empleado);

        if ($resultado) {
            echo "Empleado eliminado exitosamente.";
        } else {
            echo "Error al eliminar el empleado.";
        }
    } else {
        echo "ID de empleado no proporcionado.";
    }
}

// Incluir la vista (asegúrate de que la ruta sea correcta)
require '../Views/V_BorrarEmpleado.php';

?>