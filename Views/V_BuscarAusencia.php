<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Ausencia</title>
    <link rel="stylesheet" href="../Styles/Styles_Ausencia_Autorizacion.css">
</head>
<body>
<header>
    <h1>Buscar Ausencia por Empleado</h1>
</header>

<main>
    <form action="C_BuscarAusencia.php" method="POST">
        <div>
            <label for="ID_Empleado">ID del Empleado:</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" required>
        </div>
        <button type="submit" name="buscar">Buscar Ausencia</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Nomina Sistemas</p>
</footer>
</body>
</html>
