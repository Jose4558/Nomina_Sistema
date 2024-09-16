<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificar Empleado</title>
    <link rel="stylesheet" href="../Styles/Styles_Mod_Empleado.css">
</head>
<body>

<header>
    <h1>Modificar Empleado</h1>
</header>

<main>
    <form action="/Nomina_Sistemas/Controller/C_ModEmpleado.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="ID_Empleado">ID Empleado</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" required>
        </div>
        <div>
            <label for="Nombre">Nombre</label>
            <input type="text" id="Nombre" name="Nombre" required>
        </div>
        <div>
            <label for="Apellido">Apellido</label>
            <input type="text" id="Apellido" name="Apellido" required>
        </div>
        <div>
            <label for="Fecha_Nac">Fecha de Nacimiento</label>
            <input type="date" id="Fecha_Nac" name="Fecha_Nac" required>
        </div>
        <div>
            <label for="Fecha_Contra">Fecha de Contratación</label>
            <input type="date" id="Fecha_Contra" name="Fecha_Contra" required>
        </div>
        <div>
            <label for="Salario_Base">Salario Base</label>
            <input type="number" id="Salario_Base" name="Salario_Base" step="0.01" required>
        </div>
        <div>
            <label for="Depto_ID">ID Departamento</label>
            <input type="number" id="Depto_ID" name="Depto_ID" required>
        </div>
        <div>
            <label for="Foto">Foto</label>
            <input type="file" id="Foto" name="Foto">
        </div>
        <button type="submit">Modificar Empleado</button>
    </form>
</main>

<footer>
    <p>© 2024 Empresa XYZ. Todos los derechos reservados.</p>
</footer>

</body>
</html>
