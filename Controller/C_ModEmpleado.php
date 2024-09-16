<?php

require '../Model/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar datos del formulario
    $ID_Empleado = $_POST['ID_Empleado'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Fecha_Nac = $_POST['Fecha_Nac'];
    $Fecha_Contra = $_POST['Fecha_Contra'];
    $Salario_Base = $_POST['Salario_Base'];
    $Depto_ID = $_POST['Depto_ID'];
    $Foto = NULL;

    // Verificar si se ha subido una foto
    if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] == UPLOAD_ERR_OK) {
        $Foto = file_get_contents($_FILES['Foto']['tmp_name']);
    } else {
        echo "No se ha cargado una foto o la foto es demasiado grande.";
    }

    // Instancia de la conexión
    $conexion = new Conexion();

    // Modificar empleado con o sin foto
    $resultado = $conexion->modificarEmpleado($ID_Empleado, $Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto);

    if ($resultado) {
        echo "Empleado modificado exitosamente.";
    } else {
        echo "Error al modificar el empleado.";
    }
}

require '../Views/M_ModEmpleado.php';

?>


