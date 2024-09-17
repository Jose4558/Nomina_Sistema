<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Empleado</title>
    <link rel="stylesheet" href="../Styles/Styles_Borrar_Empleado.css"> <!-- Asegúrate de que esta ruta sea correcta -->
</head>
<body>
<header>
    <h1>Eliminar Empleado</h1>
</header>

<main>
    <form action="/Nomina_Sistemas/Controller/C_BorrarEmpleado.php" method="POST">
        <div>
            <label for="ID_Empleado">ID del Empleado:</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" required>
        </div>
        <button type="submit">Eliminar Empleado</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 TConsulting</p>
</footer>
</body>
</html>