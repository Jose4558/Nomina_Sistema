<?php

require '../Model/Conexion.php';

if (isset($_GET['id'])) {
    $id_solicitud = $_GET['id'];

    $con = new Conexion();

    // Llamar a la función para borrar la ausencia
    $resultado = $con->borrarAusencia($id_solicitud);

    if ($resultado) {
        // Redirigir a la lista de ausencias después de borrar
        header("Location: C_verAusencia.php");
        exit();
    } else {
        echo "Error al eliminar la ausencia.";
    }
} else {
    echo "ID de solicitud no proporcionado.";
}

?>


