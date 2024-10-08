<?php
require_once '../Data/ExpedienteODB.php';

$expedienteODB = new ExpedienteODB();

$idExpediente = $_GET['ID_Expediente'] ?? null;

if ($idExpediente) {
    $expediente = $expedienteODB->getById($idExpediente);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idExpediente = $_POST['ID_Expediente'];
    $tipoDocumento = $_POST['Tipo_Documento'];
    $idEmpleado = $_POST['ID_Empleado'];
    $quitarArchivo = $_POST['QuitarArchivo'] ?? false;  // Verifica si se quiere quitar el archivo

// Si se quita el archivo, se pasa null para eliminarlo, de lo contrario se procesa el archivo subido
    $archivo = (!empty($_FILES['Archivo']['tmp_name']) && !$quitarArchivo) ? file_get_contents($_FILES['Archivo']['tmp_name']) : null;

    $result = $expedienteODB->update($idExpediente, $tipoDocumento, $archivo, $idEmpleado);
    if ($result) {
        // Redireccionar a la vista de empleados si la inserción fue exitosa
        header("Location: v.Expediente.php?action=created");
        exit(); // Importante: asegura la terminación del script después de la redirección
    } else {
        // En caso de error en la inserción, podrías mostrar un mensaje de error o simplemente redirigir
        header("Location: v.Expediente.php?action=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Expediente</title>
    <link rel="stylesheet" href="../Styles/styles.css">
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
    <h1>Modificar Expediente</h1>
    <nav>
        <ul>
            <li><a href="v.Expediente.php">REGRESAR</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Expediente</h2>
        <form action="v.editar.expediente.php?ID_Expediente=<?php echo htmlspecialchars($idExpediente); ?>" method="POST" enctype="multipart/form-data" class="form-crear-editar">

            <input type="hidden" name="ID_Expediente" value="<?php echo htmlspecialchars($expediente->getIdExpediente()); ?>">

            <input type="hidden" name="ID_Empleado" value="<?php echo htmlspecialchars($expediente->getIdEmpleado()); ?>">

            <div class="form-group">
                <label for="Tipo_Documento">Tipo de Documento:</label>
                <input type="text" id="tipo_documento" name="Tipo_Documento" value="<?php echo htmlspecialchars($expediente->getTipoDocumento()); ?>" required maxlength="50" oninput="validarLongitud(this, 30)" title="El tipo de documento no puede tener más de 30 caracteres.">
            </div>

            <!-- Manejo de archivo -->
            <div class="form-group">
                <label for="Archivo">Archivo:</label>
                <input type="file" id="archivo" name="Archivo">
                <!-- Mostrar archivo existente -->
                <?php if ($expediente->getArchivo()) : ?>
                    <a href="../uploads/<?php echo htmlspecialchars($expediente->getArchivo()); ?>" target="_blank">Ver Archivo</a>
                    <input type="checkbox" id="quitar_archivo" name="Quitar_Archivo" value="1"> Quitar archivo existente
                <?php endif; ?>
            </div>

            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Actualizar Expediente</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>

