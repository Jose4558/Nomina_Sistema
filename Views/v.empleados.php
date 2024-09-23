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
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#" class="active">Empleados</a></li>
                <li><a href="v.nuevo.empleado.php">Nuevo</a></li>
                <li><a href="v.departamentos.php">Departamentos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="Empleados">
            <h2>Empleados Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Fecha de Contratación</th>
                        <th>Salario Base</th>
                        <th>Departamento</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($empleado->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getApellido()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getFechaNacimiento()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getFechaContratacion()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getSalarioBase()); ?></td>
                            <td><?php echo htmlspecialchars($empleado->getDepartamento()->getNombre()); ?></td>
                            <td><img src="<?php echo htmlspecialchars($empleado->getFoto()); ?>" alt="Foto del Empleado" width="50"></td>
                            <td>
                                <a href="v.editar.empleado.php?ID_Empleado=<?php echo $empleado->getIdEmpleado(); ?>" class="btn btn-editar">Editar</a>
                                <button class="btn btn-eliminar" data-id="<?php echo $empleado->getIdEmpleado(); ?>">Eliminar</button>
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
    </script>
</body>

</html>
