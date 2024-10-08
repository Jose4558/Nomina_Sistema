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
                <li><a href="v.familiar.php">Familiares</a></li>
                <li><a href="v.ausencias.php">Permisos</a></li>
                <li><a href="#">Evaluaciones</a></li>
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
                <li><a href="#">Cuentas por Cobrar</a></li>
                <li><a href="#">Cuentas por Pagar</a></li>
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
    <section class="Expedientes">
        <div class="search-bar">
            <form method="GET" action="">
                <label for="search">Buscar por Empleado:</label>
                <input type="text" id="search" name="nombreCompleto" placeholder="Nombre Completo">
                <button type="submit" class="btn">Buscar</button>
            </form>
        </div>
        <h2>Expedientes Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Tipo de Documento</th>
                <th>Archivo</th>
                <th>Nombre del Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_GET['nombreCompleto'])) {
                $expedientes = $expedienteODB-> buscarPorNombre($_GET['nombreCompleto']);
            }
            foreach ($expedientes as $expediente) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($expediente->getTipoDocumento()); ?></td>
                    <td>
                        <?php if ($expediente->getArchivo()) : ?>
                            <a href="descargar.php?ID_Expediente=<?php echo $expediente->getIdExpediente(); ?>">Descargar Archivo</a>
                        <?php else : ?>
                            Sin archivo
                        <?php endif; ?>
                    <td><?php echo htmlspecialchars($expediente->getNombreCompleto()); ?></td>
                    <td>
                        <a href="v.editar.expediente.php?ID_Expediente=<?php echo $expediente->getIdExpediente(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $expediente->getIdExpediente(); ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn-nuevo">Agregar Nuevo Expediente +</button>
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

    const nuevoEmpleadoButton = document.querySelector('.btn-nuevo');

    if (nuevoEmpleadoButton) {
        nuevoEmpleadoButton.addEventListener('click', function() {
            window.location.href = 'v.nuevo.expediente.php';
        });
    }
</script>
</body>

</html>

