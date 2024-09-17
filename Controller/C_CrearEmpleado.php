<?php
require '../Model/Conexion.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar datos del formulario
    $Nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : null;
    $Apellido = isset($_POST['Apellido']) ? $_POST['Apellido'] : null;
    $Fecha_Nac = isset($_POST['Fecha_Nac']) ? $_POST['Fecha_Nac'] : null;
    $Fecha_Contra = isset($_POST['Fecha_Contra']) ? $_POST['Fecha_Contra'] : null;
    $Salario_Base = isset($_POST['Salario_Base']) ? $_POST['Salario_Base'] : null;
    $Depto_ID = isset($_POST['Depto_ID']) ? $_POST['Depto_ID'] : null;
    $Foto = null; // Valor por defecto es NULL

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

// Incluir la vista (asegúrate de que la ruta sea correcta)
require '../Views/V_CrearEmpleado.php';
?>
