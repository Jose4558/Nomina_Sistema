<?php 

require_once '../Model/Usuario.php';
require_once '../Data/UsuarioODB.php';

$usuarioDB = new UsuarioODB();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $usuario = $usuarioDB->getById($_GET['id']);
        echo json_encode($usuario);
    } else {
        $usuarios = $usuarioDB->getAll();
        echo json_encode($usuarios);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $usuario = new Usuario(null, $data->Correo, $data->Contrasena, $data->ID_Rol, $data->Rol, $data->Estado);
    $usuarioDB->insert($usuario);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'));
    $usuario = new Usuario($data->ID_Usuario, $data->Correo, $data->Contrasena, $data->ID_Rol,  $data->Rol, $data->Estado);
    $usuarioDB->update($usuario);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'));
    $usuarioDB->delete($data->ID_Usuario);
}

