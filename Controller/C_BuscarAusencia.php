<?php
require '../Model/Conexion.php'; // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $ID_Empleado = isset($_POST['ID_Empleado']) ? $_POST['ID_Empleado'] : null;

    if ($ID_Empleado) {
        $conexion = new Conexion();
        $ausencia = $conexion->buscarAusenciaReciente($ID_Empleado);

        if ($ausencia) {
            // Redirigir a la vista de modificación con los datos obtenidos
            header('Location: C_AusenciaAutorizacion.php?ID_Solicitud=' . $ausencia['ID_Solicitud']);
            exit();
        } else {
            echo "No se encontró ninguna ausencia para este empleado.";
        }
    }
}
require '../Views/V_BuscarAusencia.php';
?>
