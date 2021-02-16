<?php

if(file_exists('models/cTipoRaza.php'))
{
    require_once('models/cTipoRaza.php');
}else
{
    require_once('../models/cTipoRaza.php');
}

if(file_exists('models/cEstadoSalud.php'))
{
    require_once('models/cEstadoSalud.php');
}else
{
    require_once('../models/cEstadoSalud.php');
}

class cMascota
{
    private $idMascota;
    private $name;
    private $fecha_ingreso;
    private $observaciones;
    private $status;/**int */
    private $edad;
    private $photo64;
    private $oTipoRaza;
    private $oEstadoSalud;

    public function __construct()
    {
        $this->oTipoRaza = new cTipoRaza();
        $this->oEstadoSalud = new cEstadoSalud();
    }

    public function getIdMascota()
    {
        return $this->idMascota;
    }

    public function setIdMascota($idMascota)
    {
        $this->idMascota = $idMascota;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

    public function setFechaIngreso($fecha_ingreso)
    {
        $this->fecha_ingreso = $fecha_ingreso;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    public function getPhoto64()
    {
        return $this->photo64;
    }

    public function setPhoto64($photo64)
    {
        $this->photo64 = $photo64;
    }

    public function getOTipoRaza()
    {
        return $this->oTipoRaza;
    }

    public function setOTipoRaza($oTipoRaza)
    {
        $this->oTipoRaza = $oTipoRaza;
    }

    public function getOEstadoSalud()
    {
        return $this->oEstadoSalud;
    }

    public function setOEstadoSalud($oEstadoSalud)
    {
        $this->oEstadoSalud = $oEstadoSalud;
    }

}
?>