<?php

require_once '../Model/Poliza.php';
require_once '../Data/PolizaODB.php';

$polizaContableODB = new PolizaODB();

// Verificar si se ha enviado un ID_Poliza para eliminar
if (isset($_GET['ID_Poliza'])) {
    $idPoliza = $_GET['ID_Poliza'];

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todas las pólizas para mostrar en la tabla
$polizas = $polizaContableODB->getAll();

$descripcion = $poliza->getDescripcion();

if ($idPoliza) {
    $poliza = $polizaContableODB->getById($idPoliza);

    if (!$poliza) {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Póliza no encontrada.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'v.polizas.php';
                });
              </script>";
        exit;
    }
} else {
    echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'ID de póliza no proporcionado.',
                icon: 'error'
            }).then(() => {
                window.location.href = 'v.polizas.php';
            });
          </script>";
    exit;
}

if (strpos($descripcion, 'Comisión sobre Ventas') !== false) {
    $url = "v.editar.poliza.php?ID_Poliza=" . $poliza->getIdPoliza();
} elseif (strpos($descripcion, 'Bonificación por Producción') !== false) {
    $url = "PolizaProduccion.php?ID_Poliza=" . $poliza->getIdPoliza();
} else {
    // Puedes agregar un manejo por defecto si lo deseas
    $url = "v.Poliza.php?ID_Poliza=" . $poliza->getIdPoliza(); // O una vista por defecto
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Pólizas Contables</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Pólizas Contables</h1>
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
    <section class="Polizas">
        <h2>Pólizas Registradas</h2>
        <table>
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Nombre del Empleado</th>
                <th>No. Cuenta</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($polizas as $poliza) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($poliza->getFecha()); ?></td>
                    <td><?php echo htmlspecialchars($poliza->getDescripcion()); ?></td>
                    <td><?php echo number_format($poliza->getMonto(), 2); ?></td>
                    <td><?php echo htmlspecialchars($poliza->getNombreCompleto()); ?></td>
                    <td><?php echo htmlspecialchars($poliza->getCuentaContable()); ?></td>
                    <td>
                        <a href="v.editar.poliza.php?ID_Poliza=<?php echo $poliza->getIdPoliza(); ?>" class="btn btn-editar">Ver</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>
</body>

</html>
