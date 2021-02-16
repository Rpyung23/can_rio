<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


if(file_exists('conn/conexion.php'))
{
    require_once('conn/conexion.php');
}else
{
    require_once('../conn/conexion.php');
}

if(file_exists('models/cSeguimiento.php'))
{
    require_once('models/cSeguimiento.php');
}else
{
    require_once('../models/cSeguimiento.php');
}

if(file_exists('mysql/seguimiento_mysql.php'))
{
    require_once('mysql/seguimiento_mysql.php');
}else
{
    require_once('../mysql/seguimiento_mysql.php');
}

$json = json_decode(file_get_contents('php://input'),true);
$oS = new cSeguimiento();

switch($_SERVER['REQUEST_METHOD'])
{
    case 'POST':

        $oS->getOAdopcion()->setIdAdopcion($json['id_adopcion']);
        $oS->getOVoluntario()->getODatosPersonales()->setDni($json['dni_voluntario']);
        $oS->setFecha($json['fecha']);
        $oS->setObservaciones($json['observaciones']);

        echo json_encode(insertS($oS));
        http_response_code(200);

        break;

    case 'GET':

        switch ($_SERVER['REQUEST_URI'])
        {
            case '/can_rio/rest/seguimiento.php/canino':
                echo json_encode(selectporCanino($json['id_canino']));
                http_response_code(200);
                break;
            case '/can_rio/rest/seguimiento.php/seguimientos':
                echo json_encode(selectCaninos());
                http_response_code(200);
                break;

        }

        break;
}

function insertS($oS_)
{
    return array("status_code"=>insertSeguimiento($oS_));
}

function selectporCanino($id_canino)
{
    $lista = selectSeguimientoCanino($id_canino);
    $array = null;
    if($lista != null)
    {

        for($i = 0;$i < sizeof($lista);$i++)
        {
            $array[$i] = array("id_seguimiento"=>$lista[$i]->getIdSeguimiento()
        ,"fecha_seguimiento"=>$lista[$i]->getFecha()
        ,"observaciones"=>$lista[$i]->getObservaciones()
            ,"fk_id_adopcion"=>$lista[$i]->getOAdopcion()->getIdAdopcion()
        ,"dni_voluntario"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getDni()
            ,"nombres"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getNombres()
        ,"apellidos"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getApellidos()
            ,"id_mascota"=>$lista[$i]->getOMascota()->getIdMascota()
        ,"name"=>$lista[$i]->getOMascota()->getName()
            ,"photo"=>$lista[$i]->getOMascota()->getPhoto64());
        }

        return array("status_code"=>200,"datos"=>$array);
    }

    return array("status_code"=>250,"datos"=>null);


}

function selectCaninos()
{
    $lista = selectSeguimientos();
    $array = null;
    if($lista != null)
    {

        for($i = 0;$i < sizeof($lista);$i++)
        {
            $array[$i] = array("id_seguimiento"=>$lista[$i]->getIdSeguimiento()
            ,"fecha_seguimiento"=>$lista[$i]->getFecha()
            ,"observaciones"=>$lista[$i]->getObservaciones()
            ,"fk_id_adopcion"=>$lista[$i]->getOAdopcion()->getIdAdopcion()
            ,"dni_voluntario"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getDni()
            ,"nombres"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getNombres()
            ,"apellidos"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getApellidos());
        }

        return array("status_code"=>200,"datos"=>$array);
    }

    return array("status_code"=>250,"datos"=>null);
}

?>