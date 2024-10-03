<?php

require_once '../Model/Prestamo.php';
require_once '../Data/PrestamoODB.php';

$prestamoODB = new PrestamoODB();

// Verificar si se ha enviado un ID_Prestamo para eliminar
if (isset($_GET['ID_Prestamo'])) {
    $idPrestamo = $_GET['ID_Prestamo'];

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todos los préstamos para mostrar en la tabla
$prestamos = $prestamoODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Préstamos</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>

<body>
<header>
    <h1>Gestión de Préstamos</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#" class="active">Préstamos</a></li>
            <li><a href="v.nuevo.prestamo.php">Nuevo Prestamo</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Prestamos">
        <h2>Préstamos Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Monto</th>
                <th>Cuotas</th>
                <th>Fecha de Inicio</th>
                <th>Cuotas Restantes</th>
                <th>Saldo Pendiente</th>
                <th>Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($prestamos as $prestamo) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($prestamo->getMonto()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getCuotas()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getFechaInicio()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getCuotasRestantes()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getSaldoPendiente()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getIdEmpleado()); ?></td>
                    <td>
                        <a href="v.editar.prestamo.php?ID_Prestamo=<?php echo $prestamo->getIdPrestamo(); ?>" class="btn btn-editar">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
