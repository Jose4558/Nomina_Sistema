<?php
require '../Model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $fecha = $_POST['Fecha'];
    $horaNormal = $_POST['Hora_Normal'];
    $horaDoble = $_POST['Hora_Doble'];
    $idEmpleado = $_POST['ID_Empleado'];

    // Llamar al procedimiento almacenado para calcular e insertar horas extras
    $conexion = new Conexion();
    $conexion->agregarHorasExtras($fecha, $horaNormal, $horaDoble, $idEmpleado);
    $resultado = $conexion->agregarHorasExtras($fecha, $horaNormal, $horaDoble, $idEmpleado);

    if ($resultado) {
        echo "Registro insertado exitosamente.";
    } else {
        echo "Error al insertar el Registro.";
    }
}
require '../Views/V_CrearHorasExtras.php';
?>

