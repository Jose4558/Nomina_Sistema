<?php
class Usuario {
    private $idUsuario;
    private $usuario;
    private $correo;
    private $password;
    private $empresa;
    private $idEmpleado;
    private $idRol;

    public function __construct($idUsuario = null, $usuario = null, $correo = null, $password = null, $empresa = null, $idEmpleado = null, $idRol = null) {
        $this->idUsuario = $idUsuario; // Puede ser null para nuevas inserciones
        $this->usuario = $usuario;
        $this->correo = $correo;
        $this->password = $password;
        $this->empresa = $empresa;
        $this->idEmpleado = $idEmpleado; // ID de la relación con el empleado
        $this->idRol = $idRol; // ID de la relación con el rol
    }

    // Getters
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function getIdRol() {
        return $this->idRol;
    }

    // Setters
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }
}
?>