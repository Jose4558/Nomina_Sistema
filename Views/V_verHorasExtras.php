<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Horas Extras</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Empleado.css">
    <script>
        // Función para confirmar la eliminación
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de eliminar este registro de horas extras?');
        }
    </script>
</head>
<body>
<header>
    <h1>Gestión de Horas Extras</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
            <li><a href="C_VerHorasExtras.php" class="active">Horas Extras</a></li>
            <li><a href="C_CrearHorasExtras.php">Nueva Hora Extra</a></li>
            <li><a href="C_verEmpleado.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="horas-extras">
        <h2>Horas Extras Registradas</h2>

        <!-- Mostrar mensaje de confirmación si existe -->
        <?php if (isset($_SESSION['mensaje'])) : ?>
            <div class="mensaje-exito">
                <?php
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);  // Eliminar el mensaje después de mostrarlo
                ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Horas Normales</th>
                <th>Horas Dobles</th>
                <th>Total Normal</th>
                <th>Total Doble</th>
                <th>ID del Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($horasExtras as $horaExtra) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($horaExtra['Fecha']); ?></td>
                    <td><?php echo htmlspecialchars($horaExtra['Hora_Normal']); ?></td>
                    <td><?php echo htmlspecialchars($horaExtra['Hora_Doble']); ?></td>
                    <td><?php echo htmlspecialchars($horaExtra['Total_Normal']); ?></td>
                    <td><?php echo htmlspecialchars($horaExtra['Total_Doble']); ?></td>
                    <td><?php echo htmlspecialchars($horaExtra['ID_Empleado']); ?></td>
                    <td>
                        <!-- Formulario para Editar -->
                        <form action="C_ModHorasExtras.php" method="POST" style="display:inline;">
                            <input type="hidden" name="ID_HoraExtra" value="<?php echo htmlspecialchars($horaExtra['ID_HoraExtra']); ?>">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </form>

                        <!-- Formulario para Eliminar con confirmación de JavaScript -->
                        <form action="C_BorrarHorasExtras.php" method="POST" style="display:inline;" onsubmit="return confirmarEliminacion();">
                            <input type="hidden" name="ID_HoraExtra" value="<?php echo htmlspecialchars($horaExtra['ID_HoraExtra']); ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="C_CrearHorasExtras.php" class="btn btn-agregar">+ Agregar Nueva Hora Extra</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
