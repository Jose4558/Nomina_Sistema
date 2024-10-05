<?php

require_once '../Model/HistorialPagosPrestamos.php';
require_once '../Data/HistorialPagosPrestamosODB.php';

$historialODB = new HistorialPagosPrestamosODB();

// Verificar si se ha enviado un ID_Pago para eliminar
if (isset($_GET['ID_Pago'])) {
    $idPago = $_GET['ID_Pago'];

    // Verificar si el ID_Pago es válido
    if (is_numeric($idPago)) {
        // Llamar al método para eliminar el pago en el objeto de acceso a datos
        $historialODB->delete($idPago);
        // Redirigir con un parámetro de éxito
        header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
        exit();
    } else {
        $message = 'ID de pago inválido.';
    }
}

// Obtener todo el historial de pagos para mostrar en la tabla
$historialPagos = $historialODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Pagos de Préstamos</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Historial de Pagos</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#" class="active">Historial de Pagos</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="HistorialPagos">
        <div class="search-bar">
            <form method="GET" action="">
                <label for="search">Buscar por Empleado:</label>
                <input type="text" id="search" name="nombreCompleto" placeholder="Nombre Completo">
                <button type="submit" class="btn">Buscar</button>
            </form>
        </div>

        <h2>Pagos Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Número de Cuota</th>
                <th>Saldo Pendiente</th>
                <th>Empleado</th> <!-- Aquí se muestra el nombre completo -->
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Verificar si hay un parámetro de búsqueda y realizar la búsqueda
            if (isset($_GET['nombreCompleto'])) {
                $historialPagos = $historialODB-> getByNombreCompleto($_GET['nombreCompleto']);
            }

            foreach ($historialPagos as $pago) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($pago->getFecha()); ?></td>
                    <td><?php echo htmlspecialchars($pago->getMonto()); ?></td>
                    <td><?php echo htmlspecialchars($pago->getNoCuota()); ?></td>
                    <td><?php echo htmlspecialchars($pago->getSaldoPendiente()); ?></td>
                    <td><?php echo htmlspecialchars($pago->getNombreCompleto()); ?></td> <!-- Aquí mostramos el nombre completo -->
                    <td>
                        <a href="v.editar.pago.php?ID_Pago=<?php echo $pago->getIdPago(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $pago->getIdPago(); ?>">Eliminar</button>
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
            const pagoId = this.getAttribute('data-id');

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
                    window.location.href = `?ID_Pago=${pagoId}`;
                }
            });
        });
    });
</script>
</body>

</html>
