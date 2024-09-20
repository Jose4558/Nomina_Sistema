<?php
require '../Model/Conexion.php';

$conexion = new Conexion();

// Obtener la ausencia a modificar
if (isset($_GET['id'])) {
    $ID_Solicitud = $_GET['id'];
    $ausencia = $conexion->buscarAusencia($ID_Solicitud);
    // Verifica si se encontró la ausencia
    if (!$ausencia) {
        die('Error: Ausencia no encontrada.');
    }
} else {
    die('Error: ID de solicitud no proporcionado.');
}

// Verificar si se obtuvo la ausencia correctamente
if ($ausencia) {
    // Verificar si la solicitud es POST y se presionó el botón de modificar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
        $ID_Solicitud = intval($_POST['ID_Solicitud']);
        $FechaSolicitud = $_POST['FechaSolicitud'];
        $Fecha_Inicio = $_POST['Fecha_Inicio'];
        $Fecha_Fin = $_POST['Fecha_Fin'];
        $Motivo = $_POST['Motivo'];
        $Descripcion = $_POST['Descripcion'];
        $Estado = $_POST['Estado'];
        $Cuenta_Salario = isset($_POST['Cuenta_Salario']) ? 1 : 0;
        $Descuento = isset($_POST['Descuento']) ? $_POST['Descuento'] : null;
        $ID_Empleado = $_POST['ID_Empleado'];

        // Modificar la ausencia
        $resultado = $conexion->modificarAusencia($ID_Solicitud, $FechaSolicitud, $Fecha_Inicio, $Fecha_Fin, $Motivo, $Descripcion, $Estado, $Cuenta_Salario, $Descuento, $ID_Empleado);

        if ($resultado) {
            echo "Ausencia modificada exitosamente.";
        } else {
            echo "Error al modificar la ausencia.";
        }
    }
}

// Incluir la vista
require '../Views/V_ModAusencia.php'; // Asegúrate de que esta ruta es correcta
?>



