<?php

require_once '../Model/Produccion.php';
require_once '../Data/ProduccionODB.php';

$produccionODB = new ProduccionODB();

// Verificar si se ha enviado un ID_Produccion para eliminar
if (isset($_GET['ID_Produccion'])) {
    $idProduccion = $_GET['ID_Produccion'];

    // Llamar al método para eliminar la producción en el objeto de acceso a datos
    $produccionODB->borrarProduccion($idProduccion);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todas las producciones para mostrar en la tabla
$producciones = $produccionODB->mostrarProduccion(/* Aquí puedes pasar el ID del empleado si es necesario */);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Producción</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Producción</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.produccion.php" class="active">Producción</a></li>
            <li><a href="v.nueva.produccion.php">Nueva Producción</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Produccion">
        <h2>Producción Registrada</h2>
        <table>
            <thead>
            <tr>
                <th>ID Producción</th>
                <th>Fecha</th>
                <th>Piezas Elaboradas</th>
                <th>Bonificación</th>
                <th>Empleado</th>
                <th>Poliza</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($producciones as $produccion) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($produccion->getIDProduccion()); ?></td>
                    <td><?php echo htmlspecialchars($produccion->getFecha()); ?></td>
                    <td><?php echo htmlspecialchars($produccion->getPiezasElaboradas()); ?></td>
                    <td><?php echo htmlspecialchars($produccion->getBonificacion()); ?></td>
                    <td><?php echo htmlspecialchars($produccion->getIDEmpleado()); ?></td>
                    <td><?php echo htmlspecialchars($produccion->getIDPoliza()); ?></td>
                    <td>
                        <a href="v.editar.produccion.php?ID_Produccion=<?php echo $produccion->getIDProduccion(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $produccion->getIDProduccion(); ?>">Eliminar</button>
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
            const produccionId = this.getAttribute('data-id');

            Swal.fire({
                text: "¿Seguro que quieres eliminar el registro? No podrás revertir esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `?ID_Produccion=${produccionId}`;
                }
            });
        });
    });
</script>
</body>

</html>
