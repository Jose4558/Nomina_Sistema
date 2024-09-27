<?php

class PolizaContable
{
    private $ID_Poliza;
    private $Fecha;
    private $Descripcion;
    private $Monto;
    private $Cuenta_Contable;

    public function __construct($ID_Poliza, $Fecha, $Descripcion, $Monto, $Cuenta_Contable)
    {
        $this->ID_Poliza = $ID_Poliza;
        $this->Fecha = $Fecha;
        $this->Descripcion = $Descripcion;
        $this->Monto = $Monto;
        $this->Cuenta_Contable = $Cuenta_Contable;
    }

    public function getIDPoliza()
    {
        return $this->ID_Poliza;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function getMonto()
    {
        return $this->Monto;
    }

    public function getCuentaContable()
    {
        return $this->Cuenta_Contable;
    }

    public function setIDPoliza($ID_Poliza)
    {
        $this->ID_Poliza = $ID_Poliza;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function setMonto($Monto)
    {
        $this->Monto = $Monto;
    }

    public function setCuentaContable($Cuenta_Contable)
    {
        $this->Cuenta_Contable = $Cuenta_Contable;
    }
}
?>
