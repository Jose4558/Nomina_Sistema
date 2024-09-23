<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Hora Extra</title>
    <link rel="stylesheet" href="../Styles/Styles_Mod_Empleado.css">
</head>
<body>
<header>
    <h1>Modificar Hora Extra</h1>
</header>

<form action="C_ModHorasExtras.php" method="POST">
    <input type="hidden" name="ID_HoraExtra" value="<?php echo htmlspecialchars($horaExtra['ID_HoraExtra']); ?>">

    <!-- Campo de Fecha -->
    <label for="Fecha">Fecha:</label>
    <input type="date" name="Fecha" value="<?php echo htmlspecialchars($horaExtra['Fecha']); ?>" required>

    <!-- Campo de Horas Normales -->
    <label for="Hora_Normal">Horas Normales:</label>
    <input type="number" name="Hora_Normal" step="0.01" value="<?php echo htmlspecialchars($horaExtra['Hora_Normal']); ?>" required>

    <!-- Campo de Horas Dobles -->
    <label for="Hora_Doble">Horas Dobles:</label>
    <input type="number" name="Hora_Doble" step="0.01" value="<?php echo htmlspecialchars($horaExtra['Hora_Doble']); ?>" required>

    <!-- Campo de ID Empleado -->
    <label for="ID_Empleado">ID del Empleado:</label>
    <input type="number" name="ID_Empleado" value="<?php echo htmlspecialchars($horaExtra['ID_Empleado']); ?>" required>

    <!-- Botón de Modificar -->
    <button type="submit" name="modificar">Modificar</button>
</form>

<!-- Botón de Regresar -->
<a href="C_VerHorasExtras.php">Regresar</a>
</body>
</html>



