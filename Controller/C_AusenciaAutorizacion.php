<?php
require '../Model/Conexion.php'; // Conexión a la base de datos

// Verificar si se ha proporcionado el ID de la solicitud
if (isset($_GET['ID_Solicitud'])) {
    $ID_Solicitud = $_GET['ID_Solicitud'];

    // Obtener los datos de la ausencia más reciente para el empleado
    $conexion = new Conexion();
    $ausencia = $conexion->buscarAusenciaReciente($ID_Solicitud);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    // Obtener los valores del formulario
    $ID_Solicitud = $_POST['ID_Solicitud'];
    $FechaSolicitud = $_POST['FechaSolicitud'];
    $Fecha_Inicio = $_POST['Fecha_Inicio'];
    $Fecha_Fin = $_POST['Fecha_Fin'];
    $Motivo = $_POST['Motivo'];
    $Descripcion = $_POST['Descripcion'];
    $Estado = $_POST['Estado'];
    $Cuenta_Salario = ($_POST['Cuenta_Salario'] == '1') ? 1 : 0;
    $Descuento = isset($_POST['Descuento']) ? $_POST['Descuento'] : null;
    $ID_Empleado = $_POST['ID_Empleado'];

    // Actualizar los datos de la ausencia
    $resultado = $conexion->modificarAusencia($ID_Solicitud, $FechaSolicitud, $Fecha_Inicio, $Fecha_Fin, $Motivo, $Descripcion, $Estado, $Cuenta_Salario, $Descuento, $ID_Empleado);

    if ($resultado) {
        echo "Ausencia modificada exitosamente.";
    } else {
        echo "Error al modificar la ausencia.";
    }
}

require '../Views/V_AusenciaAutorizacion.php';
?>
