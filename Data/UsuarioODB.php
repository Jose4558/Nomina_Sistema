<?php

require_once 'SQLSRVConnector.php';
require_once 'Model/Usuario.php';

class UsuarioODB {
    private $connection;

    public function __construct() {
        $this->connection = SQLSRVConnector::getInstance()->getConnection();
    }

    public function getAll() {
        $query = "SELECT
                    U.ID_Usuario, U.Correo, U.ID_Rol, U.Estado, R.Nombre AS Rol
                FROM Usuario U INNER JOIN Rol R ON U.ID_Rol = R.ID_Rol";
        $result = $this->connection->query($query);
        $usuarios = [];
        while ($row = $result->fetch()) {
            $usuario = new Usuario($row['ID_Usuario'], $row['Correo'], '', $row['ID_Rol'], $row['Rol'], $row['Estado']);
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }

    public function getById($id) {
        $query = "SELECT
                    U.ID_Usuario, U.Correo, U.Contrasena, U.ID_Rol, U.Estado, R.Nombre AS Rol
                FROM Usuario U INNER JOIN Rol R ON U.ID_Rol = R.ID_Rol
                WHERE U.ID_Usuario = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return new Usuario($row['ID_Usuario'], $row['Correo'], $row['Contrasena'], $row['ID_Rol'], $row['Rol'], $row['Estado']);
    }

    public function insert($usuario) {
        $query = "INSERT INTO Usuario (Correo, Contrasena, ID_Rol, Estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $usuario->getCorreo());
        $stmt->bindParam(2, $usuario->getContrasena());
        $stmt->bindParam(3, $usuario->getID_Rol());
        $stmt->bindParam(4, $usuario->getEstado());
        $stmt->execute();
    }

    public function update($usuario) {
        $query = "UPDATE Usuario SET Correo = ?, Contrasena = ?, ID_Rol = ?, Estado = ? WHERE ID_Usuario = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $usuario->getCorreo());
        $stmt->bindParam(2, $usuario->getContrasena());
        $stmt->bindParam(3, $usuario->getID_Rol());
        $stmt->bindParam(4, $usuario->getEstado());
        $stmt->bindParam(5, $usuario->getID_Usuario());
        $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM Usuario WHERE ID_Usuario = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }

    // Método de Login para autenticar el usuario
    public function login($usuario, $password) {
        $query = "EXEC ValidarUsuario :usuario, :password";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Si se encuentra una coincidencia, se devuelve el objeto Usuario
            return new Usuario(
                $row['ID_Usuario'],
                $row['Usuario'],
                null, // No se devuelve la contraseña por seguridad
                $row['Empresa'],
                $row['ID_Rol'],
                $row['ID_Empleado']
            );
        } else {
            // Si no hay coincidencia, devuelve null
            return null;
        }
    }
}
?>
