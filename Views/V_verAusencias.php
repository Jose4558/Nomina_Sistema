<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Ausencias</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Ausencias.css">
</head>
<body>
<header>
    <h1>Lista de Ausencias</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
            <li><a href="#" class="active">Ausencias</a></li>
            <li><a href="../Controller/C_CrearAusenciaEmpleado.php">Agregar Nueva Ausencia</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="ausencias">
        <h2>Ausencias Registradas</h2>
        <table>
            <thead>
            <tr>
                <th>ID Solicitud</th>
                <th>Fecha Solicitud</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Cuenta Salario</th>
                <th>Descuento</th>
                <th>Empleado ID</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($ausencias) && is_array($ausencias) && !empty($ausencias)): ?>
                <?php foreach ($ausencias as $ausencia): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ausencia['ID_Solicitud']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['FechaSolicitud']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Fecha_Inicio']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Fecha_Fin']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Motivo']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Estado']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Cuenta_Salario'] ? 'Sí' : 'No'); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['Descuento']); ?></td>
                        <td><?php echo htmlspecialchars($ausencia['ID_Empleado']); ?></td>
                        <td>
                            <a href="C_ActualizarAusencia.php?id=<?php echo $ausencia['ID_Solicitud']; ?>" class="btn btn-editar">Editar</a>
                            <a href="C_BorrarAusencia.php?id=<?php echo $ausencia['ID_Solicitud']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar esta ausencia?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No se encontraron ausencias.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <p><a href="../Controller/C_CrearAusenciaEmpleado.php" class="btn btn-agregar">+ Agregar Nueva Ausencia</a></p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> TConsulting</p>
</footer>
</body>
</html>

