<?php
require_once '../Data/ComisionesODB.php';
require_once '../Data/EmpleadoODB.php';

$comisionesODB = new ComisionesODB();
$empleadoODB = new EmpleadoODB();

// Obtener la lista de empleados
$empleados = $empleadoODB->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mes = intval($_POST['Mes']);
    $anio = intval($_POST['Anio']);
    $montoVentas = floatval($_POST['Monto_Ventas']);
    $idEmpleado = intval($_POST['ID_Empleado']);
    $descripcion = $_POST['Descripcion'];

    // Calcular el porcentaje de comisión según el monto de ventas
    if ($montoVentas >= 0 && $montoVentas <= 100000) {
        $porcentaje = 0.0;
    } elseif ($montoVentas >= 100001 && $montoVentas <= 200000) {
        $porcentaje = 2.5;
    } elseif ($montoVentas >= 200001 && $montoVentas <= 400000) {
        $porcentaje = 3.5;
    } else {
        $porcentaje = 4.5;
    }

    // Calcular la comisión
    $comision = ($montoVentas * $porcentaje) / 100;

    // Insertar la comisión y póliza
    $result = $comisionesODB->insertarComisionYPoliza($mes, $anio, $montoVentas, $porcentaje, $comision, $idEmpleado, $descripcion, $cuentaContable); // Cambia '0' por la cuenta contable si es necesario.

    if ($comisionesODB->insertarComisionYPoliza($mes, $anio, $montoVentas, $porcentaje, $comision, $idEmpleado, $descripcion, $cuentaContable)) {
        header("Location: v.comisiones.php?action=created");
        exit(); // Termina el script después de la redirección
    } else {
        header("Location: v.comisiones.php?action=error");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Comisión</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Registrar Comisión</h1>
    <nav>
        <ul>
            <li><a href="v.comisiones.php">REGRESAR</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="form-section">
        <h2>Registrar Nueva Comisión</h2>
        <form id="comisionForm" action="v.nueva.comision.php" method="POST" class="form-crear-editar">
            <div class="form-group">
                <label for="Mes">Mes:</label>
                <input type="number" id="mes" name="Mes" min="1" max="12" required>
            </div>
            <div class="form-group">
                <label for="Anio">Año:</label>
                <input type="number" id="anio" name="Anio" value="<?php echo date('Y'); ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="Monto_Ventas">Monto Ventas:</label>
                <input type="number" id="montoVentas" name="Monto_Ventas" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado(), ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido(), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Descripcion">Descripción:</label>
                <textarea id="descripcion" name="Descripcion" readonly required>Comisión Sobre Ventas</textarea>
            </div>
            <input type="hidden" name="Cuenta_Contable" value="0">
            <input type="hidden" name="Comision" value="<?php echo htmlspecialchars($comision, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Registrar Comisión</button>
            </div>
        </form>
    </section>
</main>
<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>

