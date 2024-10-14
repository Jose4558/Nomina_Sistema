<?php
require_once '../Data/PolizaODB.php';
require_once '../Data/PrestamoODB.php';
require_once '../Model/HistorialPagosPrestamos.php';
require_once '../Data/HistorialPagosPrestamosODB.php';
require_once '../Data/EmpleadoODB.php';

// Obtener el ID_Pago enviado desde la URL
$idPago = $_GET['ID_Pago'] ?? null;

$monto = $noCuota = $saldoPendiente = $nombreEmpleado = $idPoliza = $idPrestamo = $idEmpleado = $cuentaContable = null;

// Verificar si se obtuvo el ID_Pago y buscar los datos asociados
if ($idPago) {
    $historialPagosODB = new HistorialPagosPrestamosODB();
    $pago = $historialPagosODB->getIDPago($idPago); // Obtener datos mediante el ID_Pago

    if ($pago) {
        $monto = $pago->getMonto();
        $noCuota = $pago->getNoCuota() + 1; // Incrementar el número de cuota
        $saldoPendiente = $pago->getSaldoPendiente();
        $idEmpleado = $pago->getIdEmpleado();
        $idPoliza = $pago->getIdPoliza();
        $idPrestamo = $pago->getIdPrestamo(); // Obtener ID_Prestamo

        // Obtener nombre del empleado usando ID_Empleado
        $empleadoODB = new EmpleadoODB();
        $empleado = $empleadoODB->getById($idEmpleado);
        if ($empleado) {
            $nombreEmpleado = $empleado->getNombre() . ' ' . $empleado->getApellido(); // Concatenamos nombre y apellido
        } else {
            $nombreEmpleado = 'Empleado no encontrado';
        }

        // Obtener Cuenta Contable usando ID_Poliza
        $polizaContableODB = new PolizaODB();
        $poliza = $polizaContableODB->getById($idPoliza);
        $cuentaContable = $poliza ? $poliza->getCuentaContable() : '';
    }
}

// Calcular nuevo saldo
$nuevoSaldo = $saldoPendiente - $monto;

// Si se envió el formulario para registrar el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Registrar_Pago'])) {
    $fecha = date('Y-m-d'); // Fecha actual del sistema

    // Asegúrate de inicializar el objeto de HistorialPagosPrestamosODB
    $historialPagosODB = new HistorialPagosPrestamosODB();

    // Crear objeto de pago
    $nuevoPago = new HistorialPagosPrestamos(
        null, $fecha, $monto, $noCuota, $nuevoSaldo, $idEmpleado, $idPoliza, $idPrestamo, null, $cuentaContable
    );

    // Verificar si el objeto fue creado correctamente
    if ($nuevoPago) {
        // Insertar el nuevo pago
        $historialPagosODB->insert($nuevoPago);
    } else {
        // Manejar el error si el objeto no se creó correctamente
        echo "Error al crear el objeto de pago.";
    }

    // Mensaje de confirmación
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            Swal.fire({
                text: "PAGO REALIZADO CON ÉXITO.",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "v.nuevo.pago.php";
            });
          </script>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pago</title>
    <link rel="stylesheet" href="../Styles/styles.css">

</head>
<body>
<header>
    <h1>Realizar Pago</h1>
</header>
<nav>
    <ul>
        <li>
            <a href="index.php">Inicio</a>
        </li>
        <li>
            <a href="#">RRHH</a>
            <ul>
                <li><a href="v.empleados.php">Empleados</a></li>
                <li><a href="v.usuarios.php">Usuarios</a></li>
                <li><a href="v.Expediente.php">Expedientes</a></li>
                <li><a href="v.ausencias.php">Permisos</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Nómina</a>
            <ul>
                <li><a href="#">Pagos</a></li>
                <li><a href="#">Deducciones</a></li>
                <li><a href="#">Bonificaciones</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Contabilidad</a>
            <ul>
                <li><a href="v.Poliza.php">Polizas Contables</a></li>
                <li><a href="v.horasextras.php">Horas Extras</a></li>
                <li><a href="v.comisiones.php">Comisiones sobre ventas</a></li>
                <li><a href="v.produccion.php">Bonificaciones por producción</a></li>
                <li><a href="#">Reportes Financieros</a></li>
            </ul>
        </li>
        <li>
            <a href="#">BANTRAB</a>
            <ul>
                <li><a href="v.prestamo.php">Prestamos</a></li>
                <li><a href="v.HistorialPagosPrestamos.php">Pagos de Prestamos</a></li>
                <li><a href="v.PagosPrestamosEmpleados.php">Pagos de Prestamos por Empleado</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Configuración</a>
            <ul>
                <li><a href="#">Ajustes Generales</a></li>
                <li><a href="#">Seguridad</a></li>
            </ul>
        </li>
    </ul>
</nav>
<main>
    <form method="POST" action="v.RealizarPago.php">
        <input type="hidden" name="ID_Pago" value="<?php echo $idPago; ?>">

        <div class="form-group">
            <label for="No_Cuota">No. Cuota:</label>
            <input type="text" id="No_Cuota" name="No_Cuota" value="<?php echo $noCuota; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Nombre_Empleado">Nombre Empleado:</label>
            <input type="text" id="Nombre_Empleado" name="Nombre_Empleado" value="<?php echo $nombreEmpleado; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Monto">Monto:</label>
            <input type="text" id="Monto" name="Monto" value="<?php echo $monto; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Saldo_Pendiente">Saldo Pendiente:</label>
            <input type="text" id="Saldo_Pendiente" name="Saldo_Pendiente" value="<?php echo $saldoPendiente; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Nuevo_Saldo">Nuevo Saldo Pendiente:</label>
            <input type="text" id="Nuevo_Saldo" name="Nuevo_Saldo" value="<?php echo $nuevoSaldo; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="Cuenta_Contable">Cuenta Contable:</label>
            <input type="text" id="Cuenta_Contable" name="Cuenta_Contable" value="<?php echo htmlspecialchars($cuentaContable); ?>" readonly>
        </div>

        <div class="form-group">
            <button type="submit" name="Registrar_Pago" class="btn-submit">Registrar Pago</button>
        </div>
    </form>
</main>
<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>





