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
            <th>Fecha de Nacimiento</th>
            <th>Fecha de Contratación</th>>
            <th>Salario Base</th>
            <th>ID del Departamento</th>
            <th>Foto</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($Empleados as $Empleado) {
            echo "<tr>";
            echo "<td>" . $Empleado['Nombre'] . "</td>";
            echo "<td>" . $Empleado['Apellido'] . "</td>";
            echo "<td>" . $Empleado['Fecha_Nac'] . "</td>";
            echo "<td>" . $Empleado['Fecha_Contra']. "</td>";
            echo "<td>" . $Empleado['Salario_Base'] . "</td>";
            echo "<td>" . $Empleado['Depto_ID'] . "</td>";
            echo "<td>" . $Empleado['Foto'] . "</td>";
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
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

</body>
</html>
