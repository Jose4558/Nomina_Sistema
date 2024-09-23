<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Familiares</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Empleado.css">
</head>
<body>
<header>
    <h1>Gestión de Familiares</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
            <li><a href="V_VerFamiliar.php" class="active">Familiares</a></li>
            <li><a href="C_CrearFamiliar.php">Nuevo</a></li>
            <li><a href="C_verEmpleado.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="familiares">
        <h2>Familiares Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Relación</th>
                <th>Fecha de Nacimiento</th>
                <th>ID del Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($familiares as $familiar) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($familiar['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($familiar['Apellido']); ?></td>
                    <td><?php echo htmlspecialchars($familiar['Relacion']); ?></td>
                    <td><?php echo htmlspecialchars($familiar['FechaNacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($familiar['ID_Empleado']); ?></td>
                    <td>
                        <!-- Formulario para Editar -->
                        <form action="../Controller/C_ModFamiliar.php" method="POST" style="display:inline;">
                            <input type="hidden" name="IDFamiliar" value="<?php echo htmlspecialchars($familiar['IDFamiliar']); ?>">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </form>

                        <!-- Formulario para Eliminar -->
                        <form action="../Controller/C_BorrarFamiliar.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este familiar?');">
                            <input type="hidden" name="IDFamiliar" value="<?php echo htmlspecialchars($familiar['IDFamiliar']); ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="../Controller/C_CrearFamiliar.php" class="btn btn-agregar">+ Agregar Nuevo Familiar</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
