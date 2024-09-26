<?php
require_once '../Data/FamiliarODB.php';
require_once '../Data/EmpleadoODB.php';

$familiarODB = new FamiliarODB();
$empleadoODB = new EmpleadoODB();

// Obtener la lista de empleados
$empleados = $empleadoODB->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['Nombre']);
    $apellido = trim($_POST['Apellido']);
    $relacion = trim($_POST['Relacion']);
    $fechaNacimiento = trim($_POST['Fecha_Nacimiento']);
    $idEmpleado = intval($_POST['ID_Empleado']);

    // Perform server-side validation
    if (empty($nombre) || empty($apellido) || empty($relacion) || empty($fechaNacimiento) || empty($idEmpleado)) {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos son obligatorios.',
                icon: 'error'
            });
        </script>";
    } else {
        // Create a Familiar object
        $familiar = new Familiar($idfamiliar=null, $nombre, $apellido, $relacion, $fechaNacimiento, $idEmpleado);

        // Llamada al método de inserción
        $result = $familiarODB->insert($familiar);
        if ($result) {
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'El familiar ha sido creado correctamente.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'v.familiares.php';
                    }
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al crear el familiar.',
                    icon: 'error'
                });
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Familiar</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Crear Familiar</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.familiar.php">Familiares</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="form-section">
        <h2>Registrar Nuevo Familiar</h2>
        <form id="familiarForm" action="v.nuevo.familiar.php" method="POST" class="form-crear-editar">
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" required>
            </div>
            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" required>
            </div>
            <div class="form-group">
                <label for="Relacion">Relación:</label>
                <input type="text" id="relacion" name="Relacion" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fechaNacimiento" name="Fecha_Nacimiento" required>
            </div>
            <div class="form-group">
                <label for="ID_Empleado">Empleado:</label>
                <select id="id_empleado" name="ID_Empleado" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado(), ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido(), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Crear Familiar</button>
            </div>
        </form>
    </section>
</main>
<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>

