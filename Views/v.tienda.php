<?php

require_once '../Model/Tienda.php';
require_once '../Data/TiendaODB.php';

$tiendaODB = new TiendaODB();

// Obtener todas las compras para mostrar en la tabla
$compras = $tiendaODB->getAllTiendas();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Tienda</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>

<body>
<header>
    <h1>Gestión de Compras y Pagos</h1>
</header>
<nav>
    <ul>
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
            </ul>
        </li>
        <li>
            <a href="#">Tienda</a>
            <ul>
                <li><a href="v.tienda.php">Registro de Tienda</a></li>
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
    <section class="Compras">
        <h2>Compras Registradas</h2>
        <table>
            <thead>
            <tr>
                <th  class="text-wrap">Cuotas Máximas</th>
                <th  class="text-wrap">Saldo Pendiente</th>
                <th  class="text-wrap">Crédito Disponible</th>
                <th  class="text-wrap">Nombre del Empleado</th>
                <th>No. Cuenta</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($compras as $compra) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($compra->getCuotas()); ?></td>
                    <td><?php echo number_format($compra->getSaldoPendiente(), 2); ?></td>
                    <td><?php echo number_format($compra->getCreditoDisponible(), 2); ?></td>
                    <td><?php echo htmlspecialchars($compra->getNombreCompleto()); ?></td>
                    <td><?php echo htmlspecialchars($compra->getCuentaContable()); ?></td>
                    <td>
                        <a href="v.compra.php?ID_Empleado=<?php echo $compra->getIdEmpleado(); ?>&ID_Compra=<?php echo $compra->getIdCompra(); ?>" class="btn btn-editar">Nueva Compra</a>
                        <a href="v.PagoTienda.php?ID_Compra=<?php echo $compra->getIdCompra(); ?>" class="btn btn-buscar">Nuevo Pago</a>
                        <a href="v.HistorialCompras.php?ID_Empleado=<?php echo $compra->getIdEmpleado(); ?>" class="btn btn-editar">Historial Compras</a>
                        <a href="v.HistorialPagos.php?ID_Empleado=<?php echo $compra->getIdEmpleado(); ?>" class="btn btn-buscar">Historial Pagos</a>
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

<script>



</script>

</body>
</html>

