<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Ausencia</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Ausencia.css">
</head>
<body>
<header>
    <h1>Modificar Ausencia</h1>
</header>
<main>
    <!-- Formulario para modificar la ausencia -->
    <?php if ($ausencia): ?>
        <form action="" method="POST">
            <input type="hidden" name="ID_Solicitud" value="<?php echo htmlspecialchars($ausencia['ID_Solicitud']); ?>">

            <label for="FechaSolicitud">Fecha de Solicitud:</label>
            <input type="date" id="FechaSolicitud" name="FechaSolicitud" value="<?php echo htmlspecialchars($ausencia['FechaSolicitud']); ?>" required>

            <label for="Fecha_Inicio">Fecha de Inicio:</label>
            <input type="date" id="Fecha_Inicio" name="Fecha_Inicio" value="<?php echo htmlspecialchars($ausencia['Fecha_Inicio']); ?>" required>

            <label for="Fecha_Fin">Fecha de Fin:</label>
            <input type="date" id="Fecha_Fin" name="Fecha_Fin" value="<?php echo htmlspecialchars($ausencia['Fecha_Fin']); ?>" required>

            <label for="Motivo">Motivo:</label>
            <textarea id="Motivo" name="Motivo" required><?php echo htmlspecialchars($ausencia['Motivo']); ?></textarea>

            <label for="Descripcion">Descripción:</label>
            <textarea id="Descripcion" name="Descripcion"><?php echo htmlspecialchars($ausencia['Descripcion']); ?></textarea>

            <label for="Estado">Estado:</label>
            <select id="Estado" name="Estado" required>
                <option value="Pendiente" <?php echo ($ausencia['Estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="Aprobado" <?php echo ($ausencia['Estado'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                <option value="Rechazado" <?php echo ($ausencia['Estado'] == 'Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
            </select>

            <label for="Cuenta_Salario">Cuenta Salario:</label>
            <input type="checkbox" id="Cuenta_Salario" name="Cuenta_Salario" value="1" <?php echo ($ausencia['Cuenta_Salario']) ? 'checked' : ''; ?>>

            <label for="Descuento">Descuento:</label>
            <input type="number" id="Descuento" name="Descuento" step="0.01" value="<?php echo htmlspecialchars($ausencia['Descuento']); ?>">

            <label for="ID_Empleado">ID del Empleado:</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" value="<?php echo htmlspecialchars($ausencia['ID_Empleado']); ?>" required>

            <input type="submit" name="modificar" value="Actualizar Ausencia">
        </form>
    <?php endif; ?>
</main>
<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
