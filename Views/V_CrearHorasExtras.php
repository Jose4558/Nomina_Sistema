<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Hora Extra</title>
    <link rel="stylesheet" href="../Styles/Styles_Mod_Empleado.css">
</head>
<body>
<header>
    <h1>Agregar Hora Extra</h1>
</header>

<form action="C_CrearHorasExtras.php" method="POST">
    <!-- Campo de Fecha -->
    <label for="Fecha">Fecha:</label>
    <input type="date" name="Fecha" required>

    <!-- Campo de Horas Normales -->
    <label for="Hora_Normal">Horas Normales:</label>
    <input type="number" name="Hora_Normal" step="0.01" required>

    <!-- Campo de Horas Dobles -->
    <label for="Hora_Doble">Horas Dobles:</label>
    <input type="number" name="Hora_Doble" step="0.01" required>

    <!-- Campo de ID Empleado -->
    <label for="ID_Empleado">ID del Empleado:</label>
    <input type="number" name="ID_Empleado" required>

    <!-- Botón de Agregar -->
    <button type="submit">Agregar</button>
</form>

<!-- Botón de Regresar -->
<a href="C_VerHorasExtras.php">Regresar</a>
</body>
</html>


