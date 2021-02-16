<?php


class cTipoDonacion
{
    private $id_tipo_donacion;
    private $detalle;

    public function __construct()
    {
    }

    public function getIdTipoDonacion()
    {
        return $this->id_tipo_donacion;
    }

    public function setIdTipoDonacion($id_tipo_donacion)
    {
        $this->id_tipo_donacion = $id_tipo_donacion;
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