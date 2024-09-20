<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Familiar</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Ausencia.css">
</head>
<body>
<header>
    <h1>Agregar Familiares</h1>
    <nav>
        <ul>
            <li><a href="V_VerFamiliar.php">Regresar a Lista</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="form-familiar">
        <form action="../Controller/C_CrearFamiliar.php" method="POST">
            <?php if (isset($familiarMod)): ?>
                <input type="hidden" name="IDFamiliar" value="<?php echo htmlspecialchars($familiarMod['IDFamiliar']); ?>">
            <?php endif; ?>
            <div>
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" id="Nombre" value="<?php echo isset($familiarMod) ? htmlspecialchars($familiarMod['Nombre']) : ''; ?>" required>
            </div>
            <div>
                <label for="Apellido">Apellido:</label>
                <input type="text" name="Apellido" id="Apellido" value="<?php echo isset($familiarMod) ? htmlspecialchars($familiarMod['Apellido']) : ''; ?>" required>
            </div>
            <div>
                <label for="Relacion">Relación:</label>
                <input type="text" name="Relacion" id="Relacion" value="<?php echo isset($familiarMod) ? htmlspecialchars($familiarMod['Relacion']) : ''; ?>" required>
            </div>
            <div>
                <label for="FechaNacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo isset($familiarMod) ? htmlspecialchars($familiarMod['FechaNacimiento']) : ''; ?>" required>
            </div>
            <div>
                <label for="ID_Empleado">ID del Empleado:</label>
                <input type="number" name="ID_Empleado" id="ID_Empleado" value="<?php echo isset($familiarMod) ? htmlspecialchars($familiarMod['ID_Empleado']) : ''; ?>" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Guardar Familiar</button>
            </div>
        </form>
    </section>
</main>
<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>