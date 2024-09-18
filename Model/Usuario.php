<?php

class Usuario {
    private $ID_Usuario;
    private $Correo;
    private $Contrasena;
    private $ID_Rol;
    private $Rol;
    private $Estado;

    public function __construct($ID_Usuario, $Correo, $Contrasena, $ID_Rol, $Rol, $Estado) {
        $this->ID_Usuario = $ID_Usuario;
        $this->Correo = $Correo;
        $this->Contrasena = $Contrasena;
        $this->ID_Rol = $ID_Rol;
        $this->Rol = $Rol;
        $this->Estado = $Estado;
    }

    public function getID_Usuario() {
        return $this->ID_Usuario;
    }

    public function getCorreo() {
        return $this->Correo;
    }

    public function getContrasena() {
        return $this->Contrasena;
    }

    public function getID_Rol() {
        return $this->ID_Rol;
    }

    public function getRol() {
        return $this->Rol;
    }

    public function getEstado() {
        return $this->Estado;
    }

    public function setID_Usuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }

    public function setCorreo($Correo) {
        $this->Correo = $Correo;
    }

    public function setContrasena($Contrasena) {
        $this->Contrasena = $Contrasena;
    }

    public function setID_Rol($ID_Rol) {
        $this->ID_Rol = $ID_Rol;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    public function __toString() {
        return "ID_Usuario: $this->ID_Usuario, Correo: $this->Correo, Contrasena: $this->Contrasena, ID_Rol: $this->ID_Rol,
        Rol: $this->Rol, Estado: $this->Estado";
    }
}
