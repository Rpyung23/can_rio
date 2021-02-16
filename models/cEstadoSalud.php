<?php


class cEstadoSalud
{
    private $id_estado_salud;
    private $detalle;

    public function __construct()
    {
    }

    public function getIdEstadoSalud()
    {
        return $this->id_estado_salud;
    }

    public function setIdEstadoSalud($id_estado_salud)
    {
        $this->id_estado_salud = $id_estado_salud;
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