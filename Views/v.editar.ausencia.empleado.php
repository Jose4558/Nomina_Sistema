<?php
require_once '../Data/AusenciaODB.php';
require_once '../Data/EmpleadoODB.php';

$ausenciaODB = new AusenciaODB();
$empleadoODB = new EmpleadoODB();

$idAusencia = $_GET['ID_Solicitud'] ?? null;

if ($idAusencia) {
    $ausencia = $ausenciaODB->getById($idAusencia);
    $empleados = $empleadoODB->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAusencia = $_POST['ID_Ausencia'];
    $idEmpleado = $_POST['ID_Empleado'];
    $fechaSolicitud = $_POST['FechaSolicitud'];  // Capturamos la fecha de solicitud
    $fechaInicio = $_POST['Fecha_Inicio'];
    $fechaFin = $_POST['Fecha_Fin'];
    $motivo = $_POST['Motivo'];
    $descripcion = $_POST['Descripcion'];
    $estado = empty($_POST['Estado']) ? null : $_POST['Estado'];
    $cuentaSalario = isset($_POST['Cuenta_Salario']) ? 1 : null;
    $descuento = empty($_POST['Descuento']) ? null : $_POST['Descuento'];

    $result = $ausenciaODB->update($idAusencia, $idEmpleado, $fechaSolicitud, $fechaInicio, $fechaFin, $motivo, $descripcion, $estado, $cuentaSalario, $descuento);

    if ($result) {
        header("Location: v.ausencias.php?action=updated");
        exit();
    } else {
        header("Location: v.ausencias.php?action=error");
        exit();
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
    <script>

        function validarLongitud(input, maxLength) {
            if (input.value.length > maxLength) {
                input.setCustomValidity("Este campo no puede tener más de " + maxLength + " caracteres.");
            } else {
                input.setCustomValidity(""); // Restablecer si es válido
            }
        }

        // Validar fecha de nacimiento
        function validarFechaInicio() {
            var fechaInicio = dayjs(document.getElementById('fecha_inicio').value);
            var fechaActual = dayjs();

            // Calcular la diferencia en meses
            var diferenciaMeses = fechaInicio.diff(fechaActual, 'month', true); // true para obtener valores decimales

            if (diferenciaMeses < 0 || diferenciaMeses > 3) {
                document.getElementById('fecha_inicio').setCustomValidity("La fecha de inicio debe ser dentro de los próximos 3 meses.");
                return false;
            } else {
                document.getElementById('fecha_inicio').setCustomValidity(""); // Restablecer si es válido
                return true;
            }
        }


        function validarFechaFin() {
            var fechaInicio = dayjs(document.getElementById('fecha_inicio').value);
            var fechaFin = dayjs(document.getElementById('fecha_fin').value);

            var diferenciaDias = fechaFin.diff(fechaInicio, 'day');

            if (diferenciaDias < 0 || diferenciaDias > 15) {
                document.getElementById('fecha_fin').setCustomValidity("El período no puede superar los 15 días.");
                return false;
            } else {
                document.getElementById('fecha_fin').setCustomValidity(""); // Restablecer si es válido
                return true;
            }
        }

        // Validación del formulario al enviar
        function validarFormulario() {
            return validarFechaInicio() && validarFechaFin();
        }
    </script>
</head>
<body>
<header>
    <h1>Editar Ausencia</h1>
    <nav>
        <ul>
            <li><a href="v.ausencias.php">REGRESAR</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <form id="ausenciaForm" action="v.editar.ausencia.empleado.php?ID_Solicitud=<?php echo htmlspecialchars($idAusencia); ?>" method="POST" class="form-crear-editar">
        <input type="hidden" name="ID_Ausencia" value="<?php echo htmlspecialchars($idAusencia); ?>">
            <input type="hidden" name="ID_Empleado" value="<?php echo htmlspecialchars($ausencia->getIdEmpleado()); ?>"> <!-- Campo oculto para ID_Empleado -->
            <input type="hidden" name="FechaSolicitud" value="<?php echo htmlspecialchars($ausencia->getFechaSolicitud()); ?>">


            <div class="form-group">
                <label for="Empleado">Empleado:</label>
                <input type="text" id="empleado" value="<?php echo htmlspecialchars($empleadoODB->getById($ausencia->getIdEmpleado())->getNombre() . ' ' . $empleadoODB->getById($ausencia->getIdEmpleado())->getApellido()); ?>" disabled> <!-- Mostrar nombre sin modificar -->
            </div>

            <div class="form-group">
                <label for="Fecha_Inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="Fecha_Inicio" value="<?php echo htmlspecialchars($ausencia->getFechaInicio()); ?>" required oninput="validarFechaInicio()">
            </div>

            <div class="form-group">
                <label for="Fecha_Fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="Fecha_Fin" value="<?php echo htmlspecialchars($ausencia->getFechaFin()); ?>" required oninput="validarFechaFin()">
            </div>

            <div class="form-group">
                <label for="Motivo">Motivo:</label>
                <input type="text" id="motivo" name="Motivo" value="<?php echo htmlspecialchars($ausencia->getMotivo()); ?>" required>
            </div>

            <div class="form-group">
                <label for="Descripcion">Descripción:</label>
                <textarea id="descripcion" name="Descripcion" rows="4" cols="25" required maxlength="100" oninput="validarLongitud(this, 100)" title="La Descripción no puede tener más de 50 caracteres."><?php echo htmlspecialchars($ausencia->getDescripcion()); ?></textarea>
            </div>
            <div class="form-group">
                <label for="Estado">Estado:</label>
                <select id="estado" name="Estado">
                    <option value="">Seleccionar...</option> <!-- Opción vacía -->
                    <option value="Aprobado" <?php echo $ausencia->getEstado() === 'Aprobado' ? 'selected' : ''; ?>>Aprobado</option>
                    <option value="Pendiente" <?php echo $ausencia->getEstado() === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Rechazado" <?php echo $ausencia->getEstado() === 'Rechazado' ? 'selected' : ''; ?>>Rechazado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Cuenta_Salario">Cuenta Salario:</label>
                <input type="checkbox" id="cuenta_salario" name="Cuenta_Salario" value="1" <?php echo $ausencia->getCuentaSalario() ? 'checked' : ''; ?>>
                <!-- Si el checkbox no está marcado, no enviará ningún valor -->
            </div>

            <div class="form-group">
                <label for="Descuento">Descuento:</label>
                <input type="number" id="descuento" name="Descuento" value="<?php echo htmlspecialchars($ausencia->getDescuento()); ?>" step="0.01" placeholder="Opcional">
            </div>

            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Guardar Cambios</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>


