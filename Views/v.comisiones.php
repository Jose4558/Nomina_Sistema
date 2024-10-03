<?php

require_once '../Model/Comisiones.php';
require_once '../Data/ComisionesODB.php';

$comisionODB = new ComisionesODB();

// Verificar si se ha enviado un ID_Comision para eliminar
if (isset($_GET['ID_Comision'])) {
    $idComision = $_GET['ID_Comision'];

    // Llamar al método para eliminar la comisión en el objeto de acceso a datos
    $comisionODB->delete($idComision);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todas las comisiones para mostrar en la tabla
$comisiones = $comisionODB->getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Comisiones</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Comisiones</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.comisiones.php" class="active">Comisiones</a></li>
            <li><a href="v.nueva.comision.php">Nueva Comisión</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Comisiones">
        <h2>Comisiones Registradas</h2>
        <table>
            <thead>
            <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Monto Ventas</th>
                <th>Porcentaje</th>
                <th>Comisión</th>
                <th>Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($comisiones as $comision) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($comision->getMes()); ?></td>
                    <td><?php echo htmlspecialchars($comision->getAnio()); ?></td>
                    <td><?php echo htmlspecialchars($comision->getMontoVentas()); ?></td>
                    <td><?php echo htmlspecialchars($comision->getPorcentaje()); ?>%</td>
                    <td><?php echo htmlspecialchars($comision->getComision()); ?></td>
                    <td><?php echo htmlspecialchars($comision->getIDEmpleado()); ?></td>
                    <td>
                        <a href="v.editar.comisiones.php?ID_Comision=<?php echo $comision->getIDComision(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $comision->getIDComision(); ?>">Eliminar</button>
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
            const comisionId = this.getAttribute('data-id');

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
                    window.location.href = `?ID_Comision=${comisionId}`;
                }
            });
        });
    });
</script>
</body>

</html>