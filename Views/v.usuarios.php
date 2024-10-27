<?php
require_once '../Model/Usuario.php';
require_once '../Data/UsuarioODB.php';

$usuarioDB = new UsuarioODB();
$usuarios = $usuarioDB->getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>

<body>
    <header>
        <h1>Gestión de Usuarios</h1>
    </header>
    <nav>
        <ul>
            <li>
                <a href="#">RRHH</a>
                <ul>
                    <li><a href="v.empleados.php">Empleados</a></li>
                    <li><a href="v.usuarios.php">Usuarios</a></li>
                    <li><a href="v.Expediente.php">Expedientes</a></li>
                    <li><a href="v.ausencias.php">Permisos</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Nómina</a>
                <ul>
                    <li><a href="#">Pagos</a></li>
                    <li><a href="#">Deducciones</a></li>
                    <li><a href="#">Bonificaciones</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Contabilidad</a>
                <ul>
                    <li><a href="v.Poliza.php">Polizas Contables</a></li>
                    <li><a href="v.horasextras.php">Horas Extras</a></li>
                    <li><a href="v.comisiones.php">Comisiones sobre ventas</a></li>
                    <li><a href="v.produccion.php">Bonificaciones por producción</a></li>
                    <li><a href="#">Reportes Financieros</a></li>
                </ul>
            </li>
            <li>
                <a href="#">BANTRAB</a>
                <ul>
                    <li><a href="v.prestamo.php">Prestamos</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Tienda</a>
                <ul>
                    <li><a href="v.tienda.php">Registro de Tienda</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Configuración</a>
                <ul>
                    <li><a href="#">Ajustes Generales</a></li>
                    <li><a href="#">Seguridad</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <main>
        <section class="usuarios">
            <h2>Usuarios Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario->getID_Usuario()); ?></td>
                            <td><?php echo htmlspecialchars($usuario->getCorreo()); ?></td>
                            <td><?php echo htmlspecialchars($usuario->getRol()); ?></td>
                            <td><?php echo htmlspecialchars($usuario->getEstado() == 1 ? 'Activo' : 'Inactivo'); ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $usuario->getID_Usuario(); ?>" class="btn btn-editar">Editar</a>
                                <a href="eliminar_usuario.php?id=<?php echo $usuario->getID_Usuario(); ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> T Consulting 2024</p>
    </footer>
</body>

</html>