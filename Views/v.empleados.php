<?php

require_once '../Model/Empleado.php';
require_once '../Data/EmpleadoODB.php';

$empleadoODB = new EmpleadoODB();

// Verificar si se ha enviado un ID_Empleado para eliminar
if (isset($_GET['ID_Empleado'])) {
    $idEmpleado = $_GET['ID_Empleado'];

    // Llamar al método para eliminar el empleado en el objeto de acceso a datos
    $empleadoODB->delete($idEmpleado);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todos los empleados para mostrar en la tabla
$empleados = $empleadoODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1>Gestión de Empleados</h1>
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
        <section class="Empleados">
            <h2>Empleados Registrados</h2>
            <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th class="text-wrap">Fecha de Nacimiento</th>
                        <th class="text-wrap">Fecha de Contratación</th>
                        <th>Salario Base</th>
                        <th>Departamento</th>
                        <th>No. Cuenta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado) : ?>
                        <tr>
                            <td class="nombre"><?php echo htmlspecialchars($empleado->getNombre()); ?></td>
                            <td class="apellido"><?php echo htmlspecialchars($empleado->getApellido()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getFechaNacimiento()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getFechaContratacion()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getSalarioBase()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getDepartamento()->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getCuentaContable()); ?></td>
                            <td>
                                <a href="v.editar.empleado.php?ID_Empleado=<?php echo $empleado->getIdEmpleado(); ?>" class="btn btn-editar">Editar</a>
                                <button class="btn btn-eliminar" data-id="<?php echo $empleado->getIdEmpleado(); ?>">Eliminar</button>
                                <button class="employee-button" onclick="showEmployeePhoto('<?php echo htmlspecialchars($empleado->getFoto()); ?>')">Ver Foto</button>
                                <a href="v.familiar.php?ID_Empleado=<?php echo $empleado->getIdEmpleado(); ?>" class="btn btn-editar">Familiares</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <button class="btn-nuevo">Agregar Nuevo Empleado +</button>
            <div id="photoModal" class="photo-modal" style="display: none;">
                <span class="close" onclick="hideEmployeePhoto()">&times;</span>
                <div class="modal-content">
                    <img id="employeePhoto" src="" alt="Foto del Empleado">
                </div>
            </div>
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
                const empleadoId = this.getAttribute('data-id');

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
                        window.location.href = `?ID_Empleado=${empleadoId}`;
                    }
                });
            });
        });

        const nuevoEmpleadoButton = document.querySelector('.btn-nuevo');

        if (nuevoEmpleadoButton) {
            nuevoEmpleadoButton.addEventListener('click', function() {
                window.location.href = 'v.nuevo.empleado.php';
            });
        }

        function showEmployeePhoto(photoUrl) {
            const modal = document.getElementById("photoModal");
            const img = document.getElementById("employeePhoto");

            img.src = '../Imagenes/Sin Foto.jpeg';

            if (nuevoEmpleadoButton) {
                nuevoEmpleadoButton.style.display = "none"; // Oculta el botón
            }

            // Asegurarse de que el modal se muestre después de que la imagen haya cargado
            img.onload = function() {
                modal.style.display = "flex"; // Cambiar a flex para centrar
            }
        }

        function hideEmployeePhoto() {
            const modal = document.getElementById("photoModal");
            modal.style.display = "none";
            const img = document.getElementById("employeePhoto");
            img.src = ""; // Limpia la fuente de la imagen

            if (nuevoEmpleadoButton) {
                nuevoEmpleadoButton.style.display = "block"; // Muestra el botón nuevamente
            }
        }

    </script>
</body>

</html>
