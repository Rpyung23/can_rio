<?php

if(file_exists('models/cTipoDonacion.php'))
{
    require_once('models/cTipoDonacion.php');
}else
    {
        require_once('../models/cTipoDonacion.php');
    }

class cDonaciones
{
    private $id_donacion;
    private $name_donante;
    private $fecha_donante;
    private $valor;
    private $detalle;
    private $oTipoDonacion;

    public function __construct()
    {
        $this->oTipoDonacion = new cTipoDonacion();
    }

    public function getIdDonacion()
    {
        return $this->id_donacion;
    }

    public function setIdDonacion($id_donacion)
    {
        $this->id_donacion = $id_donacion;
    }

    public function getNameDonante()
    {
        return $this->name_donante;
    }

    public function setNameDonante($name_donante)
    {
        $this->name_donante = $name_donante;
    }

    public function getFechaDonante()
    {
        return $this->fecha_donante;
    }

    public function setFechaDonante($fecha_donante)
    {
        $this->fecha_donante = $fecha_donante;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    public function getOTipoDonacion()
    {
        return $this->oTipoDonacion;
    }

    public function setOTipoDonacion($oTipoDonacion)
    {
        $this->oTipoDonacion = $oTipoDonacion;
    }


}