<?php
require_once '../Data/PolizaODB.php';

$polizaContableODB = new PolizaODB();

$idPoliza = $_GET['ID_Poliza'] ?? null;

if ($idPoliza) {
    $poliza = $polizaContableODB->getById($idPoliza);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPoliza = $_POST['ID_Poliza'];
    $fecha = $_POST['Fecha'];
    $descripcion = $_POST['Descripción'];
    $monto = $_POST['Monto'];
    $cuentaContable = $_POST['Cuenta_Contable'];

    $result = $polizaContableODB->update($idPoliza, $fecha, $descripcion, $monto, $cuentaContable);

    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'La póliza ha sido modificada correctamente.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'v.polizas.php';
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al modificar la póliza.',
                icon: 'error'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Póliza</title>
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header>
    <h1>Editar Póliza</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="v.Poliza.php">Pólizas</a></li>
            <li><a href="v.empleados.php">Empleados</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="form-section">
        <h2>Modificar Póliza</h2>
        <form id="polizaForm" action="v.editar.poliza.php?ID_Poliza=<?php echo htmlspecialchars($idPoliza); ?>" method="POST" class="form-crear-editar">
            <input type="hidden" name="ID_Poliza" value="<?php echo htmlspecialchars($idPoliza); ?>">

            <div class="form-group">
                <label for="Fecha">Fecha:</label>
                <input type="date" id="fecha" name="Fecha" value="<?php echo htmlspecialchars($poliza->getFecha()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Descripción">Descripción:</label>
                <input type="text" id="descripcion" name="Descripción" value="<?php echo htmlspecialchars($poliza->getDescripcion()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Monto">Monto:</label>
                <input type="number" step="0.01" id="monto" name="Monto" value="<?php echo htmlspecialchars($poliza->getMonto()); ?>" required>
            </div>
            <div class="form-group">
                <label for="Cuenta_Contable">Cuenta Contable:</label>
                <input type="text" id="cuentaContable" name="Cuenta_Contable" value="<?php echo htmlspecialchars($poliza->getCuentaContable()); ?>" required>
            </div>
            <div class="form-group form-buttons">
                <button type="submit" class="btn-submit">Actualizar Registro</button>
            </div>
        </form>
    </section>
</main>

<footer>
    <p>© 2024 TConsulting. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
