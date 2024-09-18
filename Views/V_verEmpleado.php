<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Empleado.css">
</head>
<body>
<header>
    <h1>Gestión de Empleados</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
            <li><a href="#" class="active">Empleados</a></li>
            <li><a href="V_CrearEmpleado.php">Nuevo</a></li>
            <li><a href="departamentos.php">Departamentos</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="empleados">
        <h2>Empleados Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Fecha de Contratación</th>
                <th>Salario Base</th>
                <th>ID del Departamento</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($Empleados as $Empleado) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($Empleado['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($Empleado['Apellido']); ?></td>
                    <td><?php echo htmlspecialchars($Empleado['Fecha_Nac']); ?></td>
                    <td><?php echo htmlspecialchars($Empleado['Fecha_Contra']); ?></td>
                    <td><?php echo htmlspecialchars($Empleado['Salario_Base']); ?></td>
                    <td><?php echo htmlspecialchars($Empleado['Depto_ID']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($Empleado['Foto']); ?>" alt="Foto del Empleado" width="50"></td>
                    <td>
                        <a href="../Controller/C_ModEmpleado.php?id=<?php echo htmlspecialchars($Empleado['ID_Empleado']); ?>" class="btn btn-primary">Editar</a>
                        <a href="../Controller/C_BorrarEmpleado.php?id=<?php echo htmlspecialchars($Empleado['ID_Empleado']); ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este empleado?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="../Controller/C_CrearEmpleado.php" class="btn btn-agregar">+ Agregar Nuevo Empleado</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
