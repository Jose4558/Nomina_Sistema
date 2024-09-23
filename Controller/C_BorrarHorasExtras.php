<?php
session_start();  // Iniciar la sesión para almacenar mensajes de confirmación
require '../Model/Conexion.php';

if (isset($_POST['ID_HoraExtra'])) {
    $conexion = new Conexion();
    $conexion->eliminarHoraExtra($_POST['ID_HoraExtra']);

    // Mensaje de confirmación
    $_SESSION['mensaje'] = "Horas extras eliminadas correctamente.";
}

header('Location: C_VerHorasExtras.php');
?>


