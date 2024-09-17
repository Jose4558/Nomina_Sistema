<?php

require '../Model/Conexion.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar datos del formulario
    $FechaSolicitud = isset($_POST['FechaSolicitud']) ? $_POST['FechaSolicitud'] : null;
    $Fecha_Inicio = isset($_POST['Fecha_Inicio']) ? $_POST['Fecha_Inicio'] : null;
    $Fecha_Fin = isset($_POST['Fecha_Fin']) ? $_POST['Fecha_Fin'] : null;
    $Motivo = isset($_POST['Motivo']) ? $_POST['Motivo'] : null;
    $Descripcion = isset($_POST['Descripcion']) ? $_POST['Descripcion'] : null;
    $Estado = null;
    $Cuenta_Salario = null;
    $Descuento = null;
    $ID_Empleado = isset($_POST['ID_Empleado']) ? $_POST['ID_Empleado'] : null;

    // Instancia de la conexión
    $conexion = new Conexion();

    // Llamar a la función para insertar una ausencia
    $resultado = $conexion->insertarAusencia($FechaSolicitud, $Fecha_Inicio, $Fecha_Fin, $Motivo, $Descripcion, $Estado, $Cuenta_Salario, $Descuento, $ID_Empleado);

    if ($resultado) {
        echo "Ausencia insertada exitosamente.";
    } else {
        echo "Error al insertar la ausencia.";
    }
}

// Incluir la vista (asegúrate de que la ruta sea correcta)
require '../Views/V_InsertarAusencia.php';

?>
