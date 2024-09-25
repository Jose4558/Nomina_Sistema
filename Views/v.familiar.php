<?php
require_once '../Model/Familiar.php';
require_once '../Data/FamiliarODB.php';

$familiarODB = new FamiliarODB();

// Verificar si se ha enviado un ID_Familiar para eliminar
if (isset($_GET['ID_Familiar'])) {
    $idFamiliar = $_GET['ID_Familiar'];

    // Llamar al método para eliminar el familiar en el objeto de acceso a datos
    $familiarODB->delete($idFamiliar);

    // Redirigir con un parámetro de éxito
    header('Location: ' . $_SERVER['PHP_SELF'] . '?action=deleted');
    exit();
}

// Obtener todos los familiares para mostrar en la tabla
$familiares = $familiarODB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Familiares</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<header>
    <h1>Gestión de Familiares</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#" class="active">Familiares</a></li>
            <li><a href="v.nuevo.familiar.php">Nuevo</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="Familiares">
        <h2>Familiares Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Relación</th>
                <th>Fecha de Nacimiento</th>
                <th>ID. Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($familiares as $familiar) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($familiar->getNombre()); ?></td>
                    <td><?php echo htmlspecialchars($familiar->getApellido()); ?></td>
                    <td><?php echo htmlspecialchars($familiar->getRelacion()); ?></td>
                    <td><?php echo htmlspecialchars($familiar->getFechaNacimiento()); ?></td>
                    <td><?php echo htmlspecialchars($familiar->getidEmpleado()); ?></td>
                    <td>
                        <a href="v.editar.familiar.php?ID_Familiar=<?php echo $familiar->getIdFamiliar(); ?>" class="btn btn-editar">Editar</a>
                        <button class="btn btn-eliminar" data-id="<?php echo $familiar->getIdFamiliar(); ?>">Eliminar</button>
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
            const familiarId = this.getAttribute('data-id');

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
                    window.location.href = `?ID_Familiar=${familiarId}`;
                }
            });
        });
    });
</script>
</body>

</html>

