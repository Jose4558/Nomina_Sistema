<?php
require_once '../Model/Ausencia.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/AusenciaODB.php';

$empleadoODB = new EmpleadoODB();
$empleados = $empleadoODB->getAll();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEmpleado = $_POST['ID_Empleado'];
    $fechaSolicitud = date('Y-m-d');
    $fechaInicio = $_POST['Fecha_Inicio'];
    $fechaFin = $_POST['Fecha_Fin'];
    $motivo = $_POST['Motivo'];
    $descripcion = $_POST['Descripcion'];

    // Enviar cuenta salario, estado y descuento como NULL
    $cuentaSalario = null;
    $estado = null;
    $descuento = null;

    $ausencia = new Ausencia(null, $fechaSolicitud, $fechaInicio, $fechaFin, $motivo, $descripcion, $estado, $cuentaSalario, $descuento, $idEmpleado,);

    $ausenciaODB = new AusenciaODB();
    $ausenciaODB->insert($ausencia);

    $message = 'La ausencia ha sido creada correctamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Ausencia</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Gestión de Ausencias</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.ausencias.php">Ausencias</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Ausencias">
        <h2>Crear Nueva Ausencia</h2>

        <!-- Mostrar mensaje de éxito -->
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form id="ausenciaForm" action="v.nueva.ausencia.php" method="POST" class="form-crear-editar">
            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado()); ?>">
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="Fecha_Solicitud" value="<?php echo date('Y-m-d'); ?>">

            <div class="form-group">
                <label for="Fecha_Inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="Fecha_Inicio" required>
            </div>

            <div class="form-group">
                <label for="Fecha_Fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="Fecha_Fin" required>
            </div>

            <div class="form-group">
                <label for="Motivo">Motivo:</label>
                <input type="text" id="motivo" name="Motivo" required>
            </div>

            <div class="form-group">
                <label for="Descripcion">Descripción:</label>
                <textarea id="descripcion" name="Descripcion" rows="4" cols="50"></textarea>
            </div>

            <!-- Los campos ocultos para cuenta salario, estado y descuento -->
            <input type="hidden" name="Cuenta_Salario" value="NULL">
            <input type="hidden" name="Estado" value="NULL">
            <input type="hidden" name="Descuento" value="NULL">

            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Guardar Ausencia</button>
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



