<?php
require_once '../Data/EmpleadoODB.php';
require_once '../Data/DepartamentoODB.php';

$empleadoODB = new EmpleadoODB();
$departamentoODB = new DepartamentoODB();

$idEmpleado = $_GET['ID_Empleado'] ?? null;

if ($idEmpleado) {
    $empleado = $empleadoODB->getById($idEmpleado);
    $departamentos = $departamentoODB->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEmpleado = $_POST['ID_Empleado'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fechaNacimiento = $_POST['Fecha_Nac'];
    $fechaContratacion = $_POST['Fecha_Contra'];
    $salarioBase = $_POST['Salario_Base'];
    $deptoId = $_POST['Depto_ID'];
    $foto = !empty($_FILES['Foto']['tmp_name']) ? file_get_contents($_FILES['Foto']['tmp_name']) : null;
    $CuentaContable = $_POST['Cuenta_Contable'];

    $result = $empleadoODB->update($idEmpleado, $nombre, $apellido, $fechaNacimiento, $fechaContratacion, $salarioBase, $deptoId, $foto, $CuentaContable);

    if ($result) {
        // Redireccionar a la vista de empleados si la inserción fue exitosa
        header("Location: v.empleados.php?action=created");
        exit(); // Importante: asegura la terminación del script después de la redirección
    } else {
        // En caso de error en la inserción, podrías mostrar un mensaje de error o simplemente redirigir
        header("Location: v.empleados.php?action=error");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="../Styles/styles.css">

    <script>
        // Validar la longitud de caracteres en Nombre y Apellido
        function validarLongitud(input, maxLength) {
            if (input.value.length > maxLength) {
                input.setCustomValidity("Este campo no puede tener más de " + maxLength + " caracteres.");
            } else {
                input.setCustomValidity(""); // Restablecer si es válido
            }
        }

        // Validar que solo se ingresen números en el campo de Cuenta Contable
        function validarNumeros(input) {
            const regex = /^[0-9]*$/; // Solo números
            if (!regex.test(input.value)) {
                input.setCustomValidity("Solo se permiten números.");
            } else {
                input.setCustomValidity(""); // Restablecer si es válido
            }
        }

        // Validar fecha de nacimiento
        function validarFechaNacimiento() {
            var fechaNacimiento = new Date(document.getElementById('Fecha_Nac').value);
            var fechaActual = new Date();

            var fechaMinima = new Date();
            fechaMinima.setFullYear(fechaActual.getFullYear() - 70);

            var fechaMaxima = new Date();
            fechaMaxima.setFullYear(fechaActual.getFullYear() - 18);

            if (fechaNacimiento < fechaMinima || fechaNacimiento > fechaMaxima) {
                document.getElementById('Fecha_Nac').setCustomValidity("Debe ser mayor de 18 años y menor de 70.");
                return false;
            } else {
                document.getElementById('Fecha_Nac').setCustomValidity(""); // Restablecer si es válido
                return true;
            }
        }

        function validarFechaContratacion() {
            var fechaContratacion = new Date(document.getElementById('Fecha_Contra').value);
            var fechaActual = new Date();

            if (fechaContratacion > fechaActual) {
                document.getElementById('Fecha_Contra').setCustomValidity("La fecha de contratación no puede ser futura.");
                return false;
            } else {
                document.getElementById('Fecha_Contra').setCustomValidity(""); // Restablecer si es válido
                return true;
            }
        }

        // Validación del formulario al enviar
        function validarFormulario() {
            return validarFechaNacimiento() && validarFechaContratacion();
        }
    </script>

</head>
<body>
<header>
    <h1>Editar Empleado</h1>
    <nav>
        <ul>
            <li><a href="v.empleados.php">REGRESAR</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Empleado</h2>
        <form id="empleadoForm" action="v.editar.empleado.php?ID_Empleado=<?php echo htmlspecialchars($idEmpleado); ?>" method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <!-- Campo oculto para ID_Empleado -->
            <input type="hidden" name="ID_Empleado" value="<?php echo htmlspecialchars($idEmpleado); ?>">

            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="Nombre" name="Nombre" value="<?php echo htmlspecialchars($empleado->getNombre()); ?>" required maxlength="50" oninput="validarLongitud(this, 50)" title="El nombre no puede tener más de 50 caracteres.">
            </div>

            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="Apellido" name="Apellido" value="<?php echo htmlspecialchars($empleado->getApellido()); ?>" required maxlength="50" oninput="validarLongitud(this, 50)" title="El apellido no puede tener más de 50 caracteres.">
            </div>

            <div class="form-group">
                <label for="Fecha_Nac">Fecha de Nacimiento:</label>
                <input type="date" id="Fecha_Nac" name="Fecha_Nac" value="<?php echo htmlspecialchars($empleado->getFechaNacimiento()); ?>" required title="Debe ser mayor de 18 años y menor de 100." oninput="validarFechaNacimiento()">
            </div>

            <div class="form-group">
                <label for="Fecha_Contra">Fecha de Contratación:</label>
                <input type="date" id="Fecha_Contra" name="Fecha_Contra" value="<?php echo htmlspecialchars($empleado->getFechaContratacion()); ?>" required title="La fecha de contratación no puede ser futura." oninput="validarFechaContratacion()">
            </div>

            <div class="form-group">
                <label for="Salario_Base">Salario Base:</label>
                <input type="number" id="salario_base" name="Salario_Base" value="<?php echo htmlspecialchars($empleado->getSalarioBase()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Depto_ID">Departamento:</label>
                <select id="depto_id" name="Depto_ID" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo htmlspecialchars($departamento->getIdDepartamento()); ?>"
                            <?php echo $empleado->getDepartamento()->getIdDepartamento() === $departamento->getIdDepartamento() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($departamento->getNombre()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Cuenta_Contable">Cuenta Contable:</label>
                <input type="text" id="cuentaContable" name="Cuenta_Contable" value="<?php echo htmlspecialchars($empleado->getCuentaContable()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Foto">Foto:</label>
                <input type="file" id="foto" name="Foto">
                <!-- Mostrar imagen existente -->
                <?php if ($empleado->getFoto()) : ?>
                    <img src="../uploads/<?php echo htmlspecialchars($empleado->getFoto()); ?>" alt="Foto del Empleado" width="100">
                <?php endif; ?>
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


