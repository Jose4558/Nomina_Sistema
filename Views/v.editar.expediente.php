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
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'El expediente ha sido modificado correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.lista.expedientes.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar el expediente.',
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
    <title>Modificar Expediente</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Modificar Expediente</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.Expediente.php">Expedientes</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Expediente</h2>
        <form action="v.editar.expediente.php?ID_Expediente=<?php echo htmlspecialchars($idExpediente); ?>" method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <!-- Campo oculto para ID_Expediente no modificable -->
            <div class="form-group">
                <label for="ID_Expediente">ID del Expediente:</label>
                <input type="text" id="id_expediente" name="ID_Expediente" value="<?php echo htmlspecialchars($expediente->getIdExpediente()); ?>" readonly>
            </div>

            <!-- Campo no modificable para ID_Empleado -->
            <div class="form-group">
                <label for="ID_Empleado">ID del Empleado:</label>
                <input type="text" id="id_empleado" name="ID_Empleado" value="<?php echo htmlspecialchars($expediente->getIdEmpleado()); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="Tipo_Documento">Tipo de Documento:</label>
                <input type="text" id="tipo_documento" name="Tipo_Documento" value="<?php echo htmlspecialchars($expediente->getTipoDocumento()); ?>" required>
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

