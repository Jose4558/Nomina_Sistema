<?php
require '../Model/Conexion.php';

$conexion = new Conexion();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $Empleado = $conexion->buscarEmpleado($id);

    if ($Empleado) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['Nombre'], $_POST['Apellido'], $_POST['Fecha_Nac'], $_POST['Fecha_Contra'], $_POST['Salario_Base'], $_POST['Depto_ID'], $_POST['Foto'])) {
                $Nombre = $_POST['Nombre'];
                $Apellido = $_POST['Apellido'];
                $Fecha_Nac = $_POST['Fecha_Nac'];
                $Fecha_Contra = $_POST['Fecha_Contra'];
                $Salario_Base = $_POST['Salario_Base'];
                $Depto_ID = $_POST['Depto_ID'];
                $Foto = $_POST['Foto'];

                $resultado = $conexion->modificarEmpleado($id, $Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto);

                if ($resultado) {
                    header("Location: lista_empleados.php");
                    exit();
                } else {
                    echo "Error al modificar el empleado.";
                }
            } else {
                echo "No se enviaron todos los campos necesarios.";
            }
        }
    } else {
        echo "Empleado no encontrado.";
    }
} else {
    echo "ID no proporcionado o no válido.";
}
print_r($Empleado);
require '../Views/V_verEmpleado.php';
?>
