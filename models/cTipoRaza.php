<?php

class cTipoRaza
{
    private $id_tipo_raza;
    private $detalle;


    public function __construct()
    {
    }

    public function getIdTipoRaza()
    {
        return $this->id_tipo_raza;
    }

    public function setIdTipoRaza($id_tipo_raza)
    {
        $this->id_tipo_raza = $id_tipo_raza;
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }


}
?>