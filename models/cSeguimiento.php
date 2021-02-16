<?php

if(file_exists('models/cAdopcion.php'))
{
    require_once('models/cAdopcion.php');
}else
    {
        require_once('../models/cAdopcion.php');
    }

if(file_exists('models/cVoluntario.php'))
{
    require_once('models/cVoluntario.php');
}else
{
    require_once('../models/cVoluntario.php');
}

if(file_exists('models/cMascota.php'))
{
    require_once('models/cMascota.php');
}else
{
    require_once('../models/cMascota.php');
}

class cSeguimiento
{
    private $id_Seguimiento;
    private $oAdopcion;
    private $oVoluntario;
    private $oMascota;
    private $fecha;
    private $observaciones;

    public function __construct()
    {
        $this->oAdopcion = new cAdopcion();
        $this->oVoluntario = new cVoluntario();
        $this->oMascota = new cMascota();

    }

    public function getOMascota(): cMascota
    {
        return $this->oMascota;
    }

    public function setOMascota(cMascota $oMascota)
    {
        $this->oMascota = $oMascota;
    }




    public function getOVoluntario(): cVoluntario
    {
        return $this->oVoluntario;
    }

    public function setOVoluntario(cVoluntario $oVoluntario)
    {
        $this->oVoluntario = $oVoluntario;
    }

    public function getIdSeguimiento()
    {
        return $this->id_Seguimiento;
    }

    public function setIdSeguimiento($id_Seguimiento)
    {
        $this->id_Seguimiento = $id_Seguimiento;
    }

    public function getOAdopcion(): cAdopcion
    {
        return $this->oAdopcion;
    }

    public function setOAdopcion(cAdopcion $oAdopcion)
    {
        $this->oAdopcion = $oAdopcion;
    }



    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

}
?>