<?php

require '../Model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar datos del formulario
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Fecha_Nac = $_POST['Fecha_Nac'];
    $Fecha_Contra = $_POST['Fecha_Contra'];
    $Salario_Base = $_POST['Salario_Base'];
    $Depto_ID = $_POST['Depto_ID'];
    $Foto = NULL;

    // Verificar si se ha subido una foto
    if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] == UPLOAD_ERR_OK) {
        // Cargar contenido del archivo de la foto
        $Foto = file_get_contents($_FILES['Foto']['tmp_name']);
    }

    // Instancia de la conexión
    $conexion = new Conexion();

    // Llamar a la función para insertar un empleado
    $resultado = $conexion->insertarEmpleado($Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto);

    if ($resultado) {
        echo "Empleado insertado exitosamente.";
    } else {
        echo "Error al insertar el empleado.";
    }
}

// Incluir la vista
require '../Views/V_CrearEmpleado.php';

?>




