<?php
require_once '../Data/ComisionesODB.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/PolizaODB.php';

$comisionesODB = new ComisionesODB();
$empleadoODB = new EmpleadoODB();
$polizaODB = new PolizaODB();

$idComision = $_GET['ID_Comision'] ?? null;

if ($idComision) {
    // Obtener los datos de la comisión y la póliza relacionada
    $comision = $comisionesODB->getByID($idComision);
    $idPoliza = $comision["ID_Poliza"];  // Acceder como objeto
    $poliza = $polizaODB->getById($idPoliza);  // Obtener la póliza por su ID
    $empleados = $empleadoODB->getAll(); // Obtener todos los empleados
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $idComision = $_POST['ID_Comision'];
    $mes = $_POST['Mes'];
    $anio = $_POST['Anio'];
    $montoVentas = $_POST['Monto_Ventas'];
    $porcentaje = $_POST['Porcentaje'];
    $idEmpleado = $_POST['ID_Empleado'];
    $descripcion = $_POST['Descripcion'];
    $cuentaContable = $_POST['Cuenta_Contable'];

    // Llamar al método de actualización
    $result = $comisionesODB->update($idComision, $mes, $anio, $montoVentas, $porcentaje, $idEmpleado, $descripcion, $cuentaContable);

    // Verificar resultado
    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'La comisión ha sido modificada correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.comisiones.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar la comisión.',
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
    <title>Editar Comisión</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Editar Comisión</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.comisiones.php">Comisiones</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Comisión</h2>
        <form id="comisionForm" action="v.editar.comisiones.php?ID_Comision=<?php echo htmlspecialchars($idComision); ?>" method="POST" class="form-crear-editar">
            <input type="hidden" name="ID_Comision" value="<?php echo htmlspecialchars($idComision); ?>">

            <div class="form-group">
                <label for="Mes">Mes:</label>
                <input type="text" id="mes" name="Mes" value="<?php echo htmlspecialchars($comision['Mes']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Anio">Año:</label>
                <input type="text" id="anio" name="Anio" value="<?php echo htmlspecialchars($comision['Anio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Monto_Ventas">Monto de Ventas:</label>
                <input type="text" id="montoVentas" name="Monto_Ventas" value="<?php echo htmlspecialchars($comision['Monto_Ventas']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Porcentaje">Porcentaje:</label>
                <input type="text" id="porcentaje" name="Porcentaje" value="<?php echo htmlspecialchars($comision['Porcentaje']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Descripcion">Descripción:</label>
                <textarea id="descripcion" name="Descripcion" required><?php echo htmlspecialchars($poliza->getDescripcion()); ?></textarea>
            </div>
            <div class="form-group">
                <label for="Cuenta_Contable">Cuenta Contable:</label>
                <input type="text" id="cuentaContable" name="Cuenta_Contable" value="<?php echo htmlspecialchars($poliza->getCuentaContable()); ?>" required>
            </div>
            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado()); ?>" <?php echo $comision['ID_Empleado'] == $empleado->getIdEmpleado() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
</body>
</html>

