<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Expedientes</title>
    <link rel="stylesheet" href="../Styles/Styles_Ver_Ausencias.css">
</head>
<body>
<header>
    <h1>Lista de Expedientes</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
            <li><a href="#" class="active">Expedientes</a></li>
            <li><a href="../Controller/C_CrearExpediente.php">Agregar Nuevo Expediente</a></li>
        </ul>
    </nav>
</header>
<main>
    <section class="expedientes">
        <h2>Expedientes Registrados</h2>
        <table>
            <thead>
            <tr>
                <th>No Expedientes</th>
                <th>Tipo Documento</th>
                <th>Archivo</th>
                <th>ID Empleado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($expedientes) && is_array($expedientes) && !empty($expedientes)): ?>
                <?php foreach ($expedientes as $expediente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($expediente['No_Expedientes']); ?></td>
                        <td><?php echo htmlspecialchars($expediente['Tipo_Documento']); ?></td>
                        <td>
                            <?php if ($expediente['Archivo']): ?>
                                <a href="data:application/octet-stream;base64,<?php echo base64_encode($expediente['Archivo']); ?>" download="<?php echo htmlspecialchars($expediente['Tipo_Documento']); ?>">
                                    Descargar Archivo
                                </a>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($expediente['ID_Empleado']); ?></td>
                        <td>
                            <a href="C_ModExpediente.php?id=<?php echo $expediente['No_Expedientes']; ?>" class="btn btn-editar">Editar</a>

                            <!-- Formulario para eliminar el expediente usando POST -->
                            <form action="C_BorrarExpediente.php" method="POST" style="display:inline;">
                                <input type="hidden" name="No_Expedientes" value="<?php echo $expediente['No_Expedientes']; ?>">
                                <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este expediente?');">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No se encontraron expedientes.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <p><a href="../Controller/C_CrearExpediente.php" class="btn btn-agregar">+ Agregar Nuevo Expediente</a></p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> TConsulting</p>
</footer>
</body>
</html>
