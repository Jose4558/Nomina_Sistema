<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Empleado</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Empleado.css"><!-- Asegúrate de que el enlace al CSS sea correcto -->
</head>
<body>
<header>
    <h1>Formulario de Inserción de Empleado</h1>
</header>

<main>
    <form action="/Nomina_Sistemas/Controller/C_CrearEmpleado.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" required>
        </div>
        <div>
            <label for="Apellido">Apellido:</label>
            <input type="text" name="Apellido" required>
        </div>
        <div>
            <label for="Fecha_Nac">Fecha de Nacimiento:</label>
            <input type="date" name="Fecha_Nac" required>
        </div>
        <div>
            <label for="Fecha_Contra">Fecha de Contratación:</label>
            <input type="date" name="Fecha_Contra" required>
        </div>
        <div>
            <label for="Salario_Base">Salario Base:</label>
            <input type="number" name="Salario_Base" required>
        </div>
        <div>
            <label for="Depto_ID">Departamento:</label>
            <input type="number" name="Depto_ID" required>
        </div>
        <div>
            <label for="Foto">Foto:</label>
            <input type="file" name="Foto">
        </div>
        <button type="submit">Insertar</button>
    </form>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
