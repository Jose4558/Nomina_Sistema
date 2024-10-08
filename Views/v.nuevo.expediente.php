<?php
require_once '../Model/Expediente.php';
require_once '../Data/ExpedienteODB.php';
require_once '../Data/EmpleadoODB.php';

$expedienteODB = new ExpedienteODB();
$empleadoODB = new EmpleadoODB();
$empleados = $empleadoODB->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoDocumento = isset($_POST['Tipo_Documento']) ? $_POST['Tipo_Documento'] : null;
    $idEmpleado = isset($_POST['ID_Empleado']) ? $_POST['ID_Empleado'] : null;
    $quitarArchivo = $_POST['QuitarArchivo'] ?? false;  // Verifica si se quiere quitar el archivo

    // Si se quita el archivo, se pasa null para eliminarlo, de lo contrario se procesa el archivo subido
    $archivo = (!empty($_FILES['Archivo']['tmp_name']) && !$quitarArchivo) ? file_get_contents($_FILES['Archivo']['tmp_name']) : null;

    // Crear una instancia de Expediente
    $expediente = new Expediente($tipoDocumento, $idEmpleado, $archivo, $quitarArchivo);
    $expediente->setTipoDocumento($tipoDocumento);
    $expediente->setArchivo($archivo);
    $expediente->setIdEmpleado($idEmpleado);

    // Llamar al método insert
    $result = $expedienteODB->insert($expediente);
    if ($result) {
        echo "<script>Swal.fire('Éxito', 'Familiar actualizado correctamente', 'success');</script>";
        header("Location: v.expediente.php"); // Redirigir a otra vista
        exit();
    } else {
        echo "<script>Swal.fire('Error', 'No se pudo actualizar el familiar', 'error');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Expediente</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validarLongitud(input, maxLength) {
            if (input.value.length > maxLength) {
                input.setCustomValidity("Este campo no puede tener más de " + maxLength + " caracteres.");
            } else {
                input.setCustomValidity(""); // Restablecer si es válido
            }
        }
    </script>
</head>
<body>
<header>
    <h1>Crear Nuevo Expediente</h1>
    <nav>
        <ul>
            <li><a href="v.Expediente.php">REGRESAR</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Registrar Expediente</h2>
        <form id="expedienteForm" action="v.nuevo.expediente.php" method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <div class="form-group">
                <label for="Tipo_Documento">Tipo de Documento:</label>
                <input type="text" id="tipo_documento" name="Tipo_Documento" required maxlength="50" oninput="validarLongitud(this, 30)" title="El tipo de documento no puede tener más de 30 caracteres.">
            </div>
            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo $empleado->getIdEmpleado(); ?>">
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido(), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Archivo">Archivo:</label>
                <input type="file" id="archivo" name="Archivo" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png">
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Crear Expediente</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

</body>
</html>
