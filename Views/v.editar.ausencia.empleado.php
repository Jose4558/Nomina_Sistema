<?php
require_once '../Data/AusenciaODB.php';
require_once '../Data/EmpleadoODB.php';

$ausenciaODB = new AusenciaODB();
$empleadoODB = new EmpleadoODB();

$idAusencia = $_GET['ID_Ausencia'] ?? null;

if ($idAusencia) {
    $ausencia = $ausenciaODB->getById($idAusencia);
    $empleados = $empleadoODB->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAusencia = $_POST['ID_Ausencia'];
    $idEmpleado = $_POST['ID_Empleado'];
    $fechaInicio = $_POST['Fecha_Inicio'];
    $fechaFin = $_POST['Fecha_Fin'];
    $motivo = $_POST['Motivo'];
    $estado = $_POST['Estado'];
    $descuento = $_POST['Descuento'];

    $result = $ausenciaODB->update($idAusencia, $idEmpleado, $fechaInicio, $fechaFin, $motivo, $estado, $descuento);

    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'La ausencia ha sido modificada correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.ausencias.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar la ausencia.',
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
    <title>Editar Ausencia</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Editar Ausencia</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.ausencias.php">Ausencias</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Ausencia</h2>
        <form id="ausenciaForm" action="v.editar.ausencia.empleado.php?ID_Ausencia=<?php echo htmlspecialchars($idAusencia); ?>" method="POST" class="form-crear-editar">
            <!-- Campo oculto para ID_Ausencia -->
            <input type="hidden" name="ID_Ausencia" value="<?php echo htmlspecialchars($idAusencia); ?>">

            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado()); ?>"
                            <?php echo $ausencia->getIdEmpleado() === $empleado->getIdEmpleado() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Fecha_Inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="Fecha_Inicio" value="<?php echo htmlspecialchars($ausencia->getFechaInicio()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="Fecha_Fin" value="<?php echo htmlspecialchars($ausencia->getFechaFin()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Motivo">Motivo:</label>
                <input type="text" id="motivo" name="Motivo" value="<?php echo htmlspecialchars($ausencia->getMotivo()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Estado">Estado:</label>
                <select id="estado" name="Estado" required>
                    <option value="Aprobado" <?php echo $ausencia->getEstado() === 'Aprobado' ? 'selected' : ''; ?>>Aprobado</option>
                    <option value="Pendiente" <?php echo $ausencia->getEstado() === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Rechazado" <?php echo $ausencia->getEstado() === 'Rechazado' ? 'selected' : ''; ?>>Rechazado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Descuento">Descuento:</label>
                <input type="number" id="descuento" name="Descuento" value="<?php echo htmlspecialchars($ausencia->getDescuento()); ?>" required>
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
