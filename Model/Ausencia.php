<?php

class Ausencia {
    private $idSolicitud;
    private $fechaInicio;
    private $fechaFin;
    private $motivo;
    private $estado;
    private $cuentaSalario;
    private $descuento;
    private $idEmpleado; // ID del empleado asociado a la ausencia

    public function __construct($idSolicitud = null, $fechaInicio, $fechaFin, $motivo, $estado, $cuentaSalario, $descuento, $idEmpleado) {
        $this->idSolicitud = $idSolicitud; // Puede ser null
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->motivo = $motivo;
        $this->estado = $estado;
        $this->cuentaSalario = $cuentaSalario;
        $this->descuento = $descuento;
        $this->idEmpleado = $idEmpleado; // ID del empleado que hizo la solicitud
    }

    // Getters y Setters

    public function getIdSolicitud() {
        return $this->idSolicitud;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCuentaSalario() {
        return $this->cuentaSalario;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function setIdSolicitud($idSolicitud) {
        $this->idSolicitud = $idSolicitud;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCuentaSalario($cuentaSalario) {
        $this->cuentaSalario = $cuentaSalario;
    }

    public function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }
}

?>
