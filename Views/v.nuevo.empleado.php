<?php
require_once '../Model/Empleado.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/DepartamentoODB.php';

$empleadoODB = new EmpleadoODB();
$departamentoODB = new DepartamentoODB();
$departamentos = $departamentoODB->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : null;
    $apellido = isset($_POST['Apellido']) ? $_POST['Apellido'] : null;
    $fechaNacimiento = isset($_POST['Fecha_Nac']) ? $_POST['Fecha_Nac'] : null;
    $fechaContratacion = isset($_POST['Fecha_Contra']) ? $_POST['Fecha_Contra'] : null;
    $salarioBase = isset($_POST['Salario_Base']) ? $_POST['Salario_Base'] : null;
    $departamentoID = isset($_POST['Depto_ID']) ? $_POST['Depto_ID'] : null;
    $foto = !empty($_FILES['Foto']['tmp_name']) ? file_get_contents($_FILES['Foto']['tmp_name']) : null;

    if ($nombre && $apellido && $fechaNacimiento && $fechaContratacion && $salarioBase && $departamentoID) {
        $departamento = new Departamento($departamentoID, "Nombre del departamento");
        $empleado = new Empleado(null, $nombre, $apellido, $fechaNacimiento, $fechaContratacion, $salarioBase, $departamento, $foto, 1);

        if ($empleadoODB->insert($empleado)) {
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Empleado insertado correctamente.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'v.empleados.php?action=created';
                    }
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al insertar el empleado.',
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

