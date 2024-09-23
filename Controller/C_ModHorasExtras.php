<?php

require '../Model/Conexion.php';

$conexion = new Conexion();

if (isset($_POST['ID_HoraExtra'])) {
    $idHoraExtra = $_POST['ID_HoraExtra'];
    $horaExtra = $conexion->buscarHoraExtra($idHoraExtra);

    if (!$horaExtra) {
        die('Error: Hora extra no encontrada.');
    }
}

    if (isset($_POST['modificar'])) {
        // Capturar los datos del formulario
        $ID_HoraExtra = $_POST['ID_HoraExtra'];
        $Fecha = $_POST['Fecha'];
        $Hora_Normal = $_POST['Hora_Normal'];
        $Hora_Doble = $_POST['Hora_Doble'];
        $ID_Empleado = $_POST['ID_Empleado'];

        // Crear la conexión
        $conexion = new Conexion();

        // Llamar a la función para modificar la hora extra
        $resultado = $conexion->modificarHorasExtras($ID_HoraExtra, $Fecha, $Hora_Normal, $Hora_Doble, $ID_Empleado);

        // Redirigir según el resultado
        if ($resultado) {
            echo "Registro modificado exitosamente.";
        } else {
            echo "Error al modificar el Registro.";
        }
    }
require '../Views/V_ModHorasExtras.php';


