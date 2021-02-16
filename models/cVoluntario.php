<?php

if(file_exists('models/cDatosPersonales.php'))
{
    require_once('models/cDatosPersonales.php');
}else
{
    require_once('../models/cDatosPersonales.php');
}

class cVoluntario
{
    private $oDatosPersonales;
    private $status;

    public function __construct()
    {
        $this->oDatosPersonales = new cDatosPersonales();
    }

    public function getODatosPersonales(): cDatosPersonales
    {
        return $this->oDatosPersonales;
    }

    public function setODatosPersonales(cDatosPersonales $oDatosPersonales)
    {
        $this->oDatosPersonales = $oDatosPersonales;
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