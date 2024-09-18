<?php


require '../Model/Conexion.php'; // Asegúrate de que esta ruta es correcta

$conexion = new Conexion();

// Obtener la ausencia a editar
if (isset($_GET['id'])) {
    $ID_Solicitud = $_GET['id'];
    $ausencia = $conexion->buscarAusencia($ID_Solicitud); // Asegúrate de que este método existe y funciona
}

// Actualizar los datos de la ausencia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    $ID_Solicitud = $_POST['ID_Solicitud'];
    $FechaSolicitud = $_POST['FechaSolicitud'];
    $Fecha_Inicio = $_POST['Fecha_Inicio'];
    $Fecha_Fin = $_POST['Fecha_Fin'];
    $Motivo = $_POST['Motivo'];
    $Estado = $_POST['Estado'];
    $Cuenta_Salario = ($_POST['Cuenta_Salario'] == '1') ? 1 : 0;
    $Descuento = isset($_POST['Descuento']) ? $_POST['Descuento'] : null;
    $ID_Empleado = $_POST['ID_Empleado'];

    $resultado = $conexion->modificarAusencia($ID_Solicitud, $FechaSolicitud, $Fecha_Inicio, $Fecha_Fin, $Motivo, $Estado, $Cuenta_Salario, $Descuento, $ID_Empleado);

    if ($resultado) {
        echo "Ausencia modificada exitosamente.";
    } else {
        echo "Error al modificar la ausencia.";
    }
}

require '../Views/V_verAusencias.php'; // Asegúrate de que esta ruta es correcta

?>
