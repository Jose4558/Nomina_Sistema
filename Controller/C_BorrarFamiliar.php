<?php


require '../Model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IDFamiliar = $_POST['IDFamiliar'];

    $conexion = new Conexion();
    $resultado = $conexion->borrarFamiliar($IDFamiliar);

    if ($resultado) {
        echo "Registro borrado con éxito";
        exit;
    } else {
        echo "Error al eliminar el familiar.";
    }
}