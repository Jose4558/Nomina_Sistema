<?php
include_once "../Controller/C_ModExpediente.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar las entradas
    $param1 = filter_var($_POST['param1'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
    $param2 = filter_var($_POST['param2'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
    $param3 = filter_var($_POST['param3'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);

    $controlador = new C_ModExpediente();
    $controlador->modificarExpediente($param1, $param2, $param3);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Expediente</title>
    <link rel="stylesheet" href="../Styles/Styles_Crear_Empleado.css">
</head>
<body>
<header>
    <h1>Modificar Expediente</h1>
</header>
<main>
    <form action="../Controller/C_ModExpediente.php?id=<?php echo htmlspecialchars($expediente['No_Expedientes']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="No_Expedientes" value="<?php echo htmlspecialchars($expediente['No_Expedientes']); ?>">

        <label for="Tipo_Documento">Tipo de Documento:</label>
        <input type="text" id="Tipo_Documento" name="Tipo_Documento" value="<?php echo htmlspecialchars($expediente['Tipo_Documento']); ?>" required>

        <label for="Archivo">Archivo:</label>
        <input type="file" id="Archivo" name="Archivo">
        <?php if ($expediente['Archivo']): ?>
            <a href="data:application/octet-stream;base64,<?php echo base64_encode($expediente['Archivo']); ?>" download="Documento_<?php echo htmlspecialchars($expediente['No_Expedientes']); ?>">Descargar Archivo Actual</a>
        <?php endif; ?>

        <label for="ID_Empleado">ID del Empleado:</label>
        <input type="number" id="ID_Empleado" name="ID_Empleado" value="<?php echo htmlspecialchars($expediente['ID_Empleado']); ?>" required>

        <input type="submit" name="modificar" value="Actualizar Expediente">
    </form>
</main>
<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>
</body>
</html>
