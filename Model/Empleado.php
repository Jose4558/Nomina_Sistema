<?php

class Empleado {
    private $idEmpleado;
    private $nombre;
    private $apellido;
    private $fechaNacimiento;
    private $fechaContratacion;
    private $salarioBase;
    private $departamento; // Objeto Departamento
    private $foto;
    private $activo; // Nuevo campo para estado

    public function __construct($idEmpleado = null, $nombre, $apellido, $fechaNacimiento, $fechaContratacion, $salarioBase, $departamento, $foto, $activo = 1) {
        $this->idEmpleado = $idEmpleado; // Puede ser null
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->fechaContratacion = $fechaContratacion;
        $this->salarioBase = $salarioBase;
        $this->departamento = $departamento; // Debe ser una instancia de la clase Departamento
        $this->foto = $foto;
        $this->activo = $activo; // 0 para inactivo, 1 para activo
    }


    // Getters y Setters

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function getFechaContratacion() {
        return $this->fechaContratacion;
    }

    public function getSalarioBase() {
        return $this->salarioBase;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setFechaContratacion($fechaContratacion) {
        $this->fechaContratacion = $fechaContratacion;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }
}

?>
