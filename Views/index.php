<?php
session_start();
require_once '../Data/UsuarioODB.php';
require_once '../Model/Usuario.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validación en PHP para restringir caracteres especiales
    if (!preg_match('/^[a-zA-Z0-9]*$/', $usuario) || !preg_match('/^[a-zA-Z0-9]*$/', $password)) {
        $error = "Usuario o contraseña contienen caracteres no permitidos.";
    } else {
        $usuarioODB = new UsuarioODB();
        $usuarioAutenticado = $usuarioODB->login($usuario, $password);

        if ($usuarioAutenticado) {
            $_SESSION['usuario_id'] = $usuarioAutenticado->getidUsuario();
            $_SESSION['usuario_nombre'] = $usuarioAutenticado->getCorreo();
            $_SESSION['rol'] = $usuarioAutenticado->getIdRol();
            header("Location: indexAdmon.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../Styles/login.css">
    <script>
        function validarSinCaracteresEspeciales(input) {
            const regex = /^[a-zA-Z0-9]*$/;
            if (!regex.test(input.value)) {
                input.setCustomValidity("No se permiten caracteres especiales.");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
</head>
<body>
<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required pattern="[a-zA-Z0-9]*" oninput="validarSinCaracteresEspeciales(this)">
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required pattern="[a-zA-Z0-9]*" oninput="validarSinCaracteresEspeciales(this)">
        </div>
        <button type="submit">Iniciar Sesión</button>
    </form>
</div>
</body>
</html>
