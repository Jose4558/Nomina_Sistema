<?php

require '../Model/Conexion.php';

$conexion = new Conexion();

// Obtener el expediente a modificar
if (isset($_GET['id'])) {
    $No_Expedientes = $_GET['id'];
    $expediente = $conexion->buscarExpediente($No_Expedientes);

    if (!$expediente) {
        die('Error: Expediente no encontrado.');
    }
} else {
    die('Error: Número de expediente no proporcionado.');}

public function ActualizarExpediente($param1, $param2, $param3) {
    $conexion = Conexion::conectar();
    $sql = "UPDATE expediente SET columna1 = ?, columna2 = ? WHERE columna3 = ?";
    $stmt = $conexion->prepare($sql);

    // Convertir los parámetrosa la codificación correcta.
    $param1 = iconv('UTF-8', 'UTF-16LE', $param1);
    $param2 = iconv('UTF-8', 'UTF-16LE', $param2);
    $param3 = iconv('UTF-8', 'UTF-16LE', $param3);
    $stmt->execute([$param1, $param2, $param3]);
}

}
// Incluir la vista
require '../Views/V_ModExpediente.php'; // Asegúrate de que esta ruta es correcta

