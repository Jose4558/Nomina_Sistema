<?php
require_once '../Model/Empleado.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/DepartamentoODB.php';

$empleadoODB = new EmpleadoODB();

$departamentoODB = new DepartamentoODB();
$departamentos = $departamentoODB->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si los datos están presentes en $_POST
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : null;
    $fechaNacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $fechaContratacion = isset($_POST['fecha_contratacion']) ? $_POST['fecha_contratacion'] : null;
    $salarioBase = isset($_POST['salario_base']) ? $_POST['salario_base'] : null;
    $departamentoID = isset($_POST['departamento_id']) ? $_POST['departamento_id'] : null;
    $foto = !empty($_FILES['foto']['tmp_name']) ? file_get_contents($_FILES['foto']['tmp_name']) : null;

    // Solo continuar si todos los campos requeridos están presentes
    if ($nombre && $apellido && $fechaNacimiento && $fechaContratacion && $salarioBase && $departamentoID) {
        // Crear el objeto Departamento y Empleado
        $departamento = new Departamento($departamentoID, "Nombre del departamento");
        $empleado = new Empleado(null, $nombre, $apellido, $fechaNacimiento, $fechaContratacion, $salarioBase, $departamento, $foto, 1);

        // Insertar el empleado
        $empleadoODB = new EmpleadoODB();
        if ($empleadoODB->insert($empleado)) {
            echo "Empleado insertado correctamente.";
        } else {
            echo "Error al insertar el empleado.";
        }
    } else {
        echo "Por favor, completa todos los campos requeridos.";
    }
    // Redirigir al listado de empleados con confirmación de creación
    header('Location: v.empleados.php?action=created');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Empleado</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Crear Nuevo Empleado</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Registrar Empleado</h2>
        <form id="empleadoForm" action="v.nuevo.empleado.php" method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" required>
            </div>
            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Nac">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nac" name="Fecha_Nac" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Contra">Fecha de Contratación:</label>
                <input type="date" id="fecha_contra" name="Fecha_Contra" required>
            </div>
            <div class="form-group">
                <label for="Salario_Base">Salario Base:</label>
                <input type="number" id="salario_base" name="Salario_Base" required>
            </div>
            <div class="form-group">
                <label for="Depto_ID">Departamento:</label>
                <select id="depto_id" name="Depto_ID" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo $departamento->getIdDepartamento(); ?>">
                            <?php echo $departamento->getNombre(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Foto">Foto:</label>
                <input type="file" id="foto" name="Foto">
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Crear Empleado</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

</body>
</html>

