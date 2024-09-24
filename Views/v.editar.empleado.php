<?php
require_once '../Data/EmpleadoODB.php';
require_once '../Data/DepartamentoODB.php';

$empleadoODB = new EmpleadoODB();
$departamentoODB = new DepartamentoODB();

$idEmpleado = $_GET['ID_Empleado'] ?? null;

if ($idEmpleado) {
    $empleado = $empleadoODB->getById($idEmpleado);
    $departamentos = $departamentoODB->getAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEmpleado = $_POST['ID_Empleado'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fechaNacimiento = $_POST['Fecha_Nac'];
    $fechaContratacion = $_POST['Fecha_Contra'];
    $salarioBase = $_POST['Salario_Base'];
    $deptoId = $_POST['Depto_ID'];
    $foto = !empty($_FILES['Foto']['tmp_name']) ? file_get_contents($_FILES['Foto']['tmp_name']) : null;

    $result = $empleadoODB->update($idEmpleado, $nombre, $apellido, $fechaNacimiento, $fechaContratacion, $salarioBase, $deptoId, $foto);

    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'El empleado ha sido modificado correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.empleados.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar el empleado.',
                icon: 'error'
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
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Editar Empleado</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Empleado</h2>
        <form id="empleadoForm" action="v.editar.empleado.php?ID_Empleado=<?php echo htmlspecialchars($idEmpleado); ?>" method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <!-- Campo oculto para ID_Empleado -->
            <input type="hidden" name="ID_Empleado" value="<?php echo htmlspecialchars($idEmpleado); ?>">

            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" value="<?php echo htmlspecialchars($empleado->getNombre()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" value="<?php echo htmlspecialchars($empleado->getApellido()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Nac">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nac" name="Fecha_Nac" value="<?php echo htmlspecialchars($empleado->getFechaNacimiento()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Contra">Fecha de Contratación:</label>
                <input type="date" id="fecha_contra" name="Fecha_Contra" value="<?php echo htmlspecialchars($empleado->getFechaContratacion()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Salario_Base">Salario Base:</label>
                <input type="number" id="salario_base" name="Salario_Base" value="<?php echo htmlspecialchars($empleado->getSalarioBase()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Depto_ID">Departamento:</label>
                <select id="depto_id" name="Depto_ID" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo htmlspecialchars($departamento->getIdDepartamento()); ?>"
                            <?php echo $empleado->getDepartamento()->getIdDepartamento() === $departamento->getIdDepartamento() ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($departamento->getNombre()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Foto">Foto:</label>
                <input type="file" id="foto" name="Foto">
                <!-- Mostrar imagen existente -->
                <?php if ($empleado->getFoto()) : ?>
                    <img src="../uploads/<?php echo htmlspecialchars($empleado->getFoto()); ?>" alt="Foto del Empleado" width="100">
                <?php endif; ?>
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Actualizar Registro</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>


