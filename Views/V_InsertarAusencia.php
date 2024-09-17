<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Ausencia</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Ausencia.css">
</head>
<body>
<header>
    <h1>Formulario de Inserción de Ausencia</h1>
</header>

<main>
    <form action="../Controller/C_CrearAusenciaEmpleado.php" method="POST">
        <div>
            <label for="FechaSolicitud">Fecha de Solicitud:</label>
            <input type="date" id="FechaSolicitud" name="FechaSolicitud" required>
        </div>
        <div>
            <label for="Fecha_Inicio">Fecha de Inicio:</label>
            <input type="date" id="Fecha_Inicio" name="Fecha_Inicio" required>
        </div>
        <div>
            <label for="Fecha_Fin">Fecha de Fin:</label>
            <input type="date" id="Fecha_Fin" name="Fecha_Fin">
        </div>
        <div>
            <label for="Motivo">Motivo:</label>
            <input type="text" id="Motivo" name="Motivo">
        </div>
        <div>
            <label for="Descripcion">Descripción:</label>
            <textarea id="Descripcion" name="Descripcion"></textarea>
        </div>
        <div>
            <label for="ID_Empleado">ID Empleado:</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" required>
        </div>
        <div>
            <button type="submit">Insertar Ausencia</button>
        </div>
    </form>
</main>

<footer>
    <p>© 2024 Nomina Sistemas</p>
</footer>
</body>
</html>
