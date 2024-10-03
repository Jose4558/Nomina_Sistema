<?php
require_once '../Data/PrestamoODB.php';
require_once '../Model/Prestamo.php';
require_once '../Data/PolizaODB.php';
require_once '../Data/EmpleadoODB.php';

$prestamoODB = new PrestamoODB();
$empleadoODB = new EmpleadoODB();
$polizaODB = new PolizaODB();

$idPrestamo = $_GET['ID_Prestamo'] ?? null;

if ($idPrestamo) {
    $prestamo = $prestamoODB->getById($idPrestamo);
    if ($prestamo) {
        $idPoliza = $prestamo->getIdPoliza();
        $poliza = $polizaODB->getById($idPoliza);
        $idEmpleado = $prestamo->getIdEmpleado(); // Obtener el ID del empleado
        $empleados = $empleadoODB->getAll();
    } else {
        echo "Error: Préstamo no encontrado.";
        exit; // Asegúrate de detener la ejecución si no se encuentra el préstamo
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear el objeto Prestamo y asignar los valores del formulario
    $prestamo = new Prestamo();
    $prestamo->setIdPrestamo($_POST['ID_Prestamo']);
    $prestamo->setMonto($_POST['Monto']);
    $prestamo->setCuotas($_POST['Cuotas']);
    $prestamo->setFechaInicio($_POST['FechaInicio']);
    $prestamo->setCuotasRestantes($_POST['Cuotas_Restantes']);
    $prestamo->setSaldoPendiente($_POST['Saldo_Pendiente']);
    $prestamo->setCancelado($_POST['Cancelado'] ?? 0); // Valor por defecto será 0
    $prestamo->setIdEmpleado($idEmpleado); // Asignar el ID del empleado recuperado
    $prestamo->setIdPoliza($idPoliza); // Asignar el ID de la póliza recuperada

    $cuentaContable = $_POST['Cuenta_Contable'];

    // Llamar a la función update
    $result = $prestamoODB->update($prestamo, $cuentaContable);

    // Mostrar mensaje de éxito o error
    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'El préstamo ha sido modificado correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.prestamo.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar el préstamo.',
                icon: 'error'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Préstamo</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Editar Préstamo</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.prestamo.php">Préstamos</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Préstamo</h2>
        <form id="prestamoForm" action="v.editar.prestamo.php?ID_Prestamo=<?php echo htmlspecialchars($idPrestamo); ?>" method="POST" class="form-crear-editar">
            <input type="hidden" name="ID_Prestamo" value="<?php echo htmlspecialchars($idPrestamo); ?>">
            <input type="hidden" name="ID_Empleado" value="<?php echo htmlspecialchars($idEmpleado); ?>">
            <input type="hidden" name="ID_Poliza" value="<?php echo htmlspecialchars($idPoliza); ?>">

            <div class="form-group">
                <label for="Monto">Monto:</label>
                <input type="number" step="0.01" id="monto" name="Monto" value="<?php echo htmlspecialchars($prestamo->getMonto()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Cuotas">Cuotas:</label>
                <input type="number" id="cuotas" name="Cuotas" value="<?php echo htmlspecialchars($prestamo->getCuotas()); ?>" required>
            </div>
            <div class="form-group">
                <label for="FechaInicio">Fecha de Inicio:</label>
                <input type="date" id="fechaInicio" name="FechaInicio" value="<?php echo htmlspecialchars($prestamo->getFechaInicio()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Cuotas_Restantes">Cuotas Restantes:</label>
                <input type="number" id="cuotasRestantes" name="Cuotas_Restantes" value="<?php echo htmlspecialchars($prestamo->getCuotasRestantes()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Saldo_Pendiente">Cantidad a Desembolsar:</label>
                <input type="number" step="0.01" id="saldoPendiente" name="Saldo_Pendiente" value="<?php echo htmlspecialchars($prestamo->getSaldoPendiente()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Cancelado">Cancelado:</label>
                <input type="checkbox" id="cancelado" name="Cancelado" value="1" <?php echo ($prestamo->getCancelado()) ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="Cuenta_Contable">Cuenta Contable:</label>
                <input type="text" id="cuentaContable" name="Cuenta_Contable" value="<?php echo htmlspecialchars($poliza->getCuentaContable()); ?>" required>
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Actualizar Registro</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

