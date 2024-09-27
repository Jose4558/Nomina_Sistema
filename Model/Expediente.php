<?php

class Expediente {
    private $idExpediente;
    private $tipoDocumento;
    private $archivo;
    private $idEmpleado; // FK a la tabla Empleado

    public function __construct($idExpediente = null, $tipoDocumento, $archivo, $idEmpleado) {
        $this->idExpediente = $idExpediente; // Puede ser null
        $this->tipoDocumento = $tipoDocumento;
        $this->archivo = $archivo;
        $this->idEmpleado = $idEmpleado; // Debe ser un ID válido de la tabla Empleado
    }

    // Getters y Setters

    public function getIdExpediente() {
        return $this->idExpediente;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getArchivo() {
        return $this->archivo;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function setIdExpediente($idExpediente) {
        $this->idExpediente = $idExpediente;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }
}

?>
