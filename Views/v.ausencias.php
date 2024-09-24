<?php

require_once '../Model/Ausencia.php';
require_once '../Data/AusenciaODB.php';

$ausenciaODB = new AusenciaODB();

// Verificar si se ha enviado un ID_Solicitud para eliminar
if (isset($_GET['ID_Solicitud'])) {
    $idSolicitud = $_GET['ID_Solicitud'];

    // Llamar al método para eliminar la ausencia en el objeto de acceso a datos
    $ausenciaODB->delete($idSolicitud);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todas las ausencias para mostrar en la tabla
$ausencias = $ausenciaODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Ausencias</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Ausencias</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#" class="active">Ausencias</a></li>
            <li><a href="v.nueva.ausencia.php">Nueva Ausencia</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Ausencias">
        <h2>Ausencias Registradas</h2>
        <table>
            <thead>
            <tr>
                <th>ID Solicitud</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Cuenta Salario</th>
                <th>Descuento</th>
                <th>ID Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ausencias as $ausencia) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($ausencia->getIdSolicitud()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getFechaInicio()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getFechaFin()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getMotivo()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getEstado()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getCuentaSalario()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getDescuento()); ?></td>
                    <td><?php echo htmlspecialchars($ausencia->getIdEmpleado()); ?></td>
                    <td>
                        <a href="v.editar.ausencia.empleado.php?ID_Solicitud=<?php echo $ausencia->getIdSolicitud(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $ausencia->getIdSolicitud(); ?>">Eliminar</button>
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
            const ausenciaId = this.getAttribute('data-id');

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
                    window.location.href = `?ID_Solicitud=${ausenciaId}`;
                }
            });
        });
    });
</script>
</body>

</html>
