<?php

if(file_exists('models/cEstadoSalud.php'))
{
    require_once('models/cEstadoSalud.php');
}else
    {
        require_once('../models/cEstadoSalud.php');
    }

if(file_exists('models/cVoluntario.php'))
{
    require_once('models/cVoluntario.php');
}else
{
    require_once('../models/cVoluntario.php');
}

class cCasosExternos
{
    private $id_caso_externo;
    private $fecha_caso;
    private $dir_principal;
    private $dir_secondary;
    private $detalle;
    private $oVoluntario;
    private $oEstadoSalud;

    public function __construct()
    {
        $this->oEstadoSalud = new cEstadoSalud();
        $this->oVoluntario = new cVoluntario();
    }

    public function getIdCasoExterno()
    {
        return $this->id_caso_externo;
    }

    public function setIdCasoExterno($id_caso_externo)
    {
        $this->id_caso_externo = $id_caso_externo;
    }

    public function getFechaCaso()
    {
        return $this->fecha_caso;
    }

    public function setFechaCaso($fecha_caso)
    {
        $this->fecha_caso = $fecha_caso;
    }

    public function getDirPrincipal()
    {
        return $this->dir_principal;
    }

    public function setDirPrincipal($dir_principal)
    {
        $this->dir_principal = $dir_principal;
    }

    public function getDirSecondary()
    {
        return $this->dir_secondary;
    }

    public function setDirSecondary($dir_secondary)
    {
        $this->dir_secondary = $dir_secondary;
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    public function getOVoluntario(): cVoluntario
    {
        return $this->oVoluntario;
    }

    public function setOVoluntario(cVoluntario $oVoluntario)
    {
        $this->oVoluntario = $oVoluntario;
    }

    public function getOEstadoSalud(): cEstadoSalud
    {
        return $this->oEstadoSalud;
    }

    public function setOEstadoSalud(cEstadoSalud $oEstadoSalud)
    {
        $this->oEstadoSalud = $oEstadoSalud;
    }

}

?>