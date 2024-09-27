<?php

require_once '../Model/Expediente.php';
require_once '../Data/ExpedienteODB.php';

$expedienteODB = new ExpedienteODB();

// Verificar si se ha enviado un ID_Expediente para eliminar
if (isset($_GET['ID_Expediente'])) {
    $idExpediente = $_GET['ID_Expediente'];

    // Llamar al método para eliminar el expediente en el objeto de acceso a datos
    $expedienteODB->delete($idExpediente);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todos los expedientes para mostrar en la tabla
$expedientes = $expedienteODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Expedientes</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Expedientes</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#" class="active">Expedientes</a></li>
            <li><a href="v.nuevo.expediente.php">Nuevo</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Expedientes">
        <h2>Expedientes Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Tipo de Documento</th>
                <th>Archivo</th>
                <th>ID Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($expedientes as $expediente) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($expediente->getTipoDocumento()); ?></td>
                    <td>
                        <?php if ($expediente->getArchivo()) : ?>
                            <a href="descargar.php?ID_Expediente=<?php echo $expediente->getIdExpediente(); ?>">Descargar Archivo</a>
                        <?php else : ?>
                            Sin archivo
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($expediente->getIdEmpleado()); ?></td>
                    <td>
                        <a href="v.editar.expediente.php?ID_Expediente=<?php echo $expediente->getIdExpediente(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $expediente->getIdExpediente(); ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const deleteButtons = document.querySelectorAll('.btn-eliminar');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const expedienteId = this.getAttribute('data-id');

            Swal.fire({
                text: "Seguro que quieres eliminar el registro, no podrás revertir esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `?ID_Expediente=${expedienteId}`;
                }
            });
        });
    });
</script>
</body>

</html>

