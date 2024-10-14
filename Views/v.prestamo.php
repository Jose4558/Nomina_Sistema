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
</header>
<nav>
    <ul>
        <li>
            <a href="index.php">Inicio</a>
        </li>
        <li>
            <a href="#">RRHH</a>
            <ul>
                <li><a href="v.empleados.php">Empleados</a></li>
                <li><a href="v.usuarios.php">Usuarios</a></li>
                <li><a href="v.Expediente.php">Expedientes</a></li>
                <li><a href="v.ausencias.php">Permisos</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Nómina</a>
            <ul>
                <li><a href="#">Pagos</a></li>
                <li><a href="#">Deducciones</a></li>
                <li><a href="#">Bonificaciones</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Contabilidad</a>
            <ul>
                <li><a href="v.Poliza.php">Polizas Contables</a></li>
                <li><a href="v.horasextras.php">Horas Extras</a></li>
                <li><a href="v.comisiones.php">Comisiones sobre ventas</a></li>
                <li><a href="v.produccion.php">Bonificaciones por producción</a></li>
                <li><a href="#">Reportes Financieros</a></li>
            </ul>
        </li>
        <li>
            <a href="#">BANTRAB</a>
            <ul>
                <li><a href="v.prestamo.php">Prestamos</a></li>
                <li><a href="v.HistorialPagosPrestamos.php">Pagos de Prestamos</a></li>
                <li><a href="v.PagosPrestamosEmpleados.php">Pagos de Prestamos por Empleado</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Configuración</a>
            <ul>
                <li><a href="#">Ajustes Generales</a></li>
                <li><a href="#">Seguridad</a></li>
            </ul>
        </li>
    </ul>
</nav>
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
                    <td><?php echo number_format($prestamo->getMonto(), 2); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getCuotas()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getFechaInicio()); ?></td>
                    <td><?php echo htmlspecialchars($prestamo->getCuotasRestantes()); ?></td>
                    <td><?php echo number_format($prestamo->getSaldoPendiente(), 2); ?></td>
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
