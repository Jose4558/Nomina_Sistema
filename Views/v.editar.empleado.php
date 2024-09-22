<?php

require_once '../Model/Empleado.php';
require_once '../Data/EmpleadoODB.php';
require_once '../Data/DepartamentoODB.php';

$empleadoODB = new EmpleadoODB();
$departamentoODB = new DepartamentoODB();
$departamentos = $departamentoODB->getAll();

// Verificar si se ha enviado un ID_Empleado para editar
if (isset($_GET['ID_Empleado'])) {
    $idEmpleado = $_GET['ID_Empleado'];
    
    $empleado = $empleadoODB->getById($idEmpleado);
}

// Verificar si se ha enviado el formulario de actualización o inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fechaNac = $_POST['Fecha_Nac'];
    $fechaContra = $_POST['Fecha_Contra'];
    $salarioBase = $_POST['Salario_Base'];
    $deptoID = $_POST['Depto_ID'];
    
    if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
        // Procesar la foto (mover el archivo y almacenar la ruta)
        $foto = $_FILES['Foto']['name'];
        move_uploaded_file($_FILES['Foto']['tmp_name'], "../uploads/" . $foto);
    } else {
        // Si no se ha subido una nueva foto, mantener la existente (solo en edición)
        $foto = isset($empleado) ? $empleado->getFoto() : null;
    }

    // Si estamos editando un empleado
    if (isset($idEmpleado)) {
        // Crear un nuevo objeto Empleado con los datos actualizados
        $empleadoActualizado = new Empleado($idEmpleado, $nombre, $apellido, $fechaNac, $fechaContra, $salarioBase, new Departamento($deptoID, ''), $foto);
        
        // Llamar al método update del objeto de acceso a datos
        $empleadoODB->update($empleadoActualizado);
        
        // Redirigir al listado de empleados con confirmación de actualización
        header('Location: v.empleados.php?action=updated');
        exit();
    } else {
        // Crear un nuevo objeto Empleado con los datos del formulario (sin ID)
        $empleadoNuevo = new Empleado(null, $nombre, $apellido, $fechaNac, $fechaContra, $salarioBase, new Departamento($deptoID, ''), $foto);
        
        // Llamar al método insert del objeto de acceso a datos
        $empleadoODB->insert($empleadoNuevo);
        
        // Redirigir al listado de empleados con confirmación de creación
        header('Location: v.empleados.php?action=created');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Incluir SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Gestión de Empleados</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
            <li><a href="#" class="active">Nuevo</a></li>
            <li><a href="v.departamentos.php">Departamentos</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2><?php echo isset($empleado) ? 'Editar Empleado' : 'Nuevo Empleado'; ?></h2>
        <form id="empleadoForm" action="<?php echo $_SERVER['PHP_SELF'] . (isset($empleado) ? '?ID_Empleado=' . $empleado->getIdEmpleado() : ''); ?>" 
              method="POST" enctype="multipart/form-data" class="form-crear-editar">
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" value="<?php echo isset($empleado) ? htmlspecialchars($empleado->getNombre()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="Apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" value="<?php echo isset($empleado) ? htmlspecialchars($empleado->getApellido()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Nac">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nac" name="Fecha_Nac" value="<?php echo isset($empleado) ? htmlspecialchars($empleado->getFechaNacimiento()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="Fecha_Contra">Fecha de Contratación:</label>
                <input type="date" id="fecha_contra" name="Fecha_Contra" value="<?php echo isset($empleado) ? htmlspecialchars($empleado->getFechaContratacion()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="Salario_Base">Salario Base:</label>
                <input type="number" id="salario_base" name="Salario_Base" value="<?php echo isset($empleado) ? htmlspecialchars($empleado->getSalarioBase()) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="Depto_ID">Departamento:</label>
                <select id="depto_id" name="Depto_ID" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo $departamento->getIdDepartamento(); ?>" 
                            <?php echo isset($empleado) && $empleado->getDepartamento()->getIdDepartamento() === $departamento->getIdDepartamento() ? 'selected' : ''; ?>>
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
                <button type="button" id="submitBtn" class="btn-submit"><?php echo isset($empleado) ? 'Actualizar Registro' : 'Guardar Registro'; ?></button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

<!-- Script para manejar la validación y confirmación con SweetAlert2 -->
<script>
    document.getElementById('submitBtn').addEventListener('click', function(event) {
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const fechaNac = document.getElementById('fecha_nac').value;
        const fechaContra = document.getElementById('fecha_contra').value;
        const salarioBase = document.getElementById('salario_base').value.trim();
        const deptoID = document.getElementById('depto_id').value;

        if (!nombre || !apellido || !fechaNac || !fechaContra || !salarioBase || !deptoID) {
            Swal.fire({
                text: 'Todos los campos son obligatorios',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                text: "<?php echo isset($empleado) ? '¿Deseas actualizar este registro?' : '¿Deseas guardar este nuevo registro?'; ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('empleadoForm').submit();
                }
            });
        }
    });
</script>

</body>
</html>
