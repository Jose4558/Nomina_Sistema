<?php
require '../Model/Conexion.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
$id = $_GET['id'];
$conexion = new Conexion();
$empleado = $conexion->buscarEmpleadoPorID($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
// Otros campos

$conexion->modificarEmpleado($ID_Empleado, $Nombre, $Apellido, $Fecha_Nac, $Fecha_Contra, $Salario_Base, $Depto_ID, $Foto);
header("Location: lista_empleados.php");
}
}

require '../Views/V_verEmpleado.php';


?>


