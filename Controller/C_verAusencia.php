<?php

require '../Model/Conexion.php';

$con = new Conexion();

// Obtener la lista de ausencias
$ausencias = $con->getAusencias(); // Verifica que esta variable no sea null

// Verificar si la variable ausencias tiene datos
if ($ausencias === null) {
    $ausencias = []; // Asignar un array vacío si no hay datos
}

// Pasar las ausencias a la vista
require '../Views/V_verAusencias.php';

?>
