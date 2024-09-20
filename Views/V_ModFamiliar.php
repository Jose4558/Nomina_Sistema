<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Familiar</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Ausencia.css">
</head>
<body>
<header>
    <h1>Modificar Familiares</h1>
    <nav>
        <ul>
            <li><a href="V_VerFamiliar.php">Regresar a Lista</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="form-familiar">
        <form action="../Controller/C_ModFamiliar.php" method="POST">
            <!-- Enviar el IDFamiliar como un campo oculto -->
            <input type="hidden" name="IDFamiliar" value="<?php echo htmlspecialchars($familiar['IDFamiliar']); ?>">

            <div>
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($familiar['Nombre']); ?>" required>
            </div>

            <div>
                <label for="Apellido">Apellido:</label>
                <input type="text" name="Apellido" id="Apellido" value="<?php echo htmlspecialchars($familiar['Apellido']); ?>" required>
            </div>

            <div>
                <label for="Relacion">Relación:</label>
                <input type="text" name="Relacion" id="Relacion" value="<?php echo htmlspecialchars($familiar['Relacion']); ?>" required>
            </div>

            <div>
                <label for="FechaNacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo htmlspecialchars($familiar['FechaNacimiento']); ?>" required>
            </div>

            <div>
                <label for="ID_Empleado">ID del Empleado:</label>
                <input type="number" name="ID_Empleado" id="ID_Empleado" value="<?php echo htmlspecialchars($familiar['ID_Empleado']); ?>" required>
            </div>

            <div>
                <button type="submit" name="modificar" class="btn btn-primary">Modificar Familiar</button>
            </div>
        </form>
    </section>
</main>
<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>

