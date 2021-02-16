<?php

if(file_exists('models/cAdoptante.php'))
{
    require_once('models/cAdoptante.php');
}else
    {
        require_once('../models/cAdoptante.php');
    }

if(file_exists('models/cMascota.php'))
{
    require_once('models/cMascota.php');
}else
{
    require_once('../models/cMascota.php');
}


class cAdopcion
{
    private $oMascota;
    private $oAdoptante;
    private $id_adopcion;
    private $fecha_adopcion;
    private $status;

    public function __construct()
    {
        $this->oMascota = new cMascota();
        $this->oAdoptante = new cAdoptante();
    }

    public function getIdAdopcion()
    {
        return $this->id_adopcion;
    }

    public function setIdAdopcion($id_adopcion)
    {
        $this->id_adopcion = $id_adopcion;
    }

    public function getOMascota(): cMascota
    {
        return $this->oMascota;
    }

    public function setOMascota(cMascota $oMascota)
    {
        $this->oMascota = $oMascota;
    }

    public function getOAdoptante(): cAdoptante
    {
        return $this->oAdoptante;
    }

    public function setOAdoptante(cAdoptante $oAdoptante)
    {
        $this->oAdoptante = $oAdoptante;
    }

    public function getFechaAdopcion()
    {
        return $this->fecha_adopcion;
    }

    public function setFechaAdopcion($fecha_adopcion)
    {
        $this->fecha_adopcion = $fecha_adopcion;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }



}

?>