<?php

require_once '../Model/Departamento.php';

class Empleado {
    private $ID_Empleado;
    private $Nombre;
    private $Apellido;
    private $Fecha_Nacimineto;
    private $Fecha_Contratacion;
    private $Salario_Base;
    private $Departamento;
    private $Foto;

    public function __construct($ID_Empleado, $Nombre, $Apellido, $Fecha_Nacimineto, $Fecha_Contratacion, $Salario_Base, $Departamento, $Foto) {
        $this->ID_Empleado = $ID_Empleado;
        $this->Nombre = $Nombre;
        $this->Apellido = $Apellido;
        $this->Fecha_Nacimineto = $Fecha_Nacimineto;
        $this->Fecha_Contratacion = $Fecha_Contratacion;
        $this->Salario_Base = $Salario_Base;
        $this->Departamento = $Departamento;
        $this->Foto = $Foto;
    }

    public function getIDEmpleado() {
        return $this->ID_Empleado;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function getApellido() {
        return $this->Apellido;
    }

    public function getFechaNacimiento() {
        return $this->Fecha_Nacimineto;
    }

    public function getFechaContraTacion() {
        return $this->Fecha_Contratacion;
    }

    public function getSalarioBase() {
        return $this->Salario_Base;
    }

    public function getDepartamento() : Departamento {
        return $this->Departamento;
    }

    public function getFoto() {
        return $this->Foto;
    }

}