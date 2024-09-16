<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista De Empleados</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Empleado.css">
</head>
<body>

<header>
    <h1>Lista De Empleados</h1>
</header>

<main>
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Salario Base</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($Empleados as $Empleado) {
            echo "<tr>";
            echo "<td>" . $Empleado['Nombre'] . "</td>";
            echo "<td>" . $Empleado['Apellido'] . "</td>";
            echo "<td>" . $Empleado['Salario_Base'] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <aside>
        <h2>Información Adicional</h2>
        <p>Aquí puedes colocar cualquier información adicional sobre los empleados o la empresa.</p>
    </aside>
</main>

<footer>
    <p>© 2024 Empresa XYZ. Todos los derechos reservados.</p>
</footer>

</body>
</html>
