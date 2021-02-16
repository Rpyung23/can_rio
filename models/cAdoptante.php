<?php

if(file_exists('models/cDatosPersonales.php'))
{
    require_once('models/cDatosPersonales.php');
}else
{
    require_once('../models/cDatosPersonales.php');
}

class cAdoptante
{
    private $oDatosPersonales;

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



}

?>