<?php
require_once '../Model/Familiar.php';
require_once '../Data/FamiliarODB.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/SQLSRVConnector.php';

$familiarODB = new FamiliarODB();
$empleadoODB = new EmpleadoODB();

$idFamiliar = $_GET['ID_Familiar'] ?? null;

if ($idFamiliar) {
    $familiar = $familiarODB->getById($idFamiliar);
    $empleados = $empleadoODB->getAll(); // Suponiendo que necesitas todos los empleados para asociar al familiar
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idFamiliar = $_POST['ID_Familiar'];
    $nombre = $_POST['Nombre'] ?? null;
    $apellido = $_POST['Apellido'] ?? null;
    $relacion = $_POST['Relacion'] ?? null;
    $fechaNacimiento = $_POST['Fecha_Nac'] ?? null;
    $empleadoID = $_POST['Empleado_ID'] ?? null;

    if ($nombre && $apellido && $relacion && $fechaNacimiento && $empleadoID) {
        $familiar = new Familiar($idFamiliar, $nombre, $apellido, $relacion, $fechaNacimiento, $empleadoID);

        if ($familiarODB->insert($familiar)) {
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Familiar modificado correctamente.',
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
                    text: 'Error al modificar el familiar.',
                    icon: 'error'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Advertencia',
                text: 'Por favor, completa todos los campos requeridos.',
                icon: 'warning'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Familiar</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Crear Nuevo Familiar</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.familiar.php">Familiares</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Crear Nuevo Familiar</h2>
        <form id="familiarForm" action="v.nuevo.familiar.php?ID_Familiar=<?php echo htmlspecialchars($idFamiliar); ?>" method="POST" class="form-crear-editar">
            <!-- Campo oculto para ID_Familiar -->
            <input type="hidden" name="ID_Familiar" value="<?php echo htmlspecialchars($idFamiliar); ?>">

            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" value="<?php echo htmlspecialchars($familiar->getNombre()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" value="<?php echo htmlspecialchars($familiar->getApellido()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Relacion">Relacion:</label>
                <input type="text" id="relacion" name="Relacion" value="<?php echo htmlspecialchars($familiar->getRelacion()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Nac">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nac" name="Fecha_Nac" value="<?php echo htmlspecialchars($familiar->getFechaNacimiento()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Empleado_ID">Empleado Asociado:</label>
                <select id="empleado_id" name="Empleado_ID" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($empleados as $empleado) : ?>
                        <option value="<?php echo htmlspecialchars($empleado->getIdEmpleado()); ?>"
                            <?php echo $familiar->getEmpleadoID() === $empleado->getIdEmpleado() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Actualizar Familiar</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>

