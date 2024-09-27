<?php

class Comision
{
    private $ID_Comision;
    private $Mes;
    private $Anio;
    private $Monto_Ventas;
    private $Porcentaje;
    private $Comision;
    private $ID_Empleado;
    private $ID_Poliza;

    public function __construct($ID_Comision, $Mes, $Anio, $Monto_Ventas, $Porcentaje, $Comision, $ID_Empleado, $ID_Poliza)
    {
        $this->ID_Comision = $ID_Comision;
        $this->Mes = $Mes;
        $this->Anio = $Anio;
        $this->Monto_Ventas = $Monto_Ventas;
        $this->Porcentaje = $Porcentaje;
        $this->Comision = $Comision;
        $this->ID_Empleado = $ID_Empleado;
        $this->ID_Poliza = $ID_Poliza;
    }

    public function getIDComision()
    {
        return $this->ID_Comision;
    }

    public function getMes()
    {
        return $this->Mes;
    }

    public function getAnio()
    {
        return $this->Anio;
    }

    public function getMontoVentas()
    {
        return $this->Monto_Ventas;
    }

    public function getPorcentaje()
    {
        return $this->Porcentaje;
    }

    public function getComision()
    {
        return $this->Comision;
    }

    public function getIDEmpleado()
    {
        return $this->ID_Empleado;
    }

    public function getIDPoliza()
    {
        return $this->ID_Poliza;
    }

    public function setID_Comision($ID_Comision)
    {
        $this->ID_Comision = $ID_Comision;
    }

    public function setMes($Mes)
    {
        $this->Mes = $Mes;
    }

    public function setAnio($Anio)
    {
        $this->Anio = $Anio;
    }

    public function setMontoVentas($Monto_Ventas)
    {
        $this->Monto_Ventas = $Monto_Ventas;
    }

    public function setPorcentaje($Porcentaje)
    {
        $this->Porcentaje = $Porcentaje;
    }

    public function setComision($Comision)
    {
        $this->Comision = $Comision;
    }

    public function setID_Empleado($ID_Empleado)
    {
        $this->ID_Empleado = $ID_Empleado;
    }

    public function setID_Poliza($ID_Poliza)
    {
        $this->ID_Poliza = $ID_Poliza;
    }
}
