<?php

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Methods: PUT, POST, GET, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

if(file_exists('conn/conexion.php'))
{
    require_once('conn/conexion.php');
}else
{
    require_once('../conn/conexion.php');
}

if(file_exists('models/cMascota.php'))
{
    require_once('models/cMascota.php');
}else
{
    require_once('../models/cMascota.php');
}

if(file_exists('mysql/mascota_mysql.php'))
{
    require_once('mysql/mascota_mysql.php');
}else
{
    require_once('../mysql/mascota_mysql.php');
}

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        echo json_encode(selectId($_GET['id_mascota']));
        http_response_code(200);
        break;
}


function selectId($id)
{
    $listM = selectMascota($id);

    if($listM!=null)
    {
        $listM = array("idMascota"=>$listM->getIdMascota()
        ,"name"=>$listM->getName()
        ,"fecha_ingreso"=>$listM->getFechaIngreso()
        ,"observaciones"=>$listM->getObservaciones()
        ,"status"=>$listM->getStatus()
        ,"edad"=>$listM->getEdad()
        ,"photo64"=>$listM->getPhoto64()
        ,"idTipoRaza"=>$listM->getOTipoRaza()->getIdTipoRaza()
        ,"detalleTipoRaza"=>$listM->getOTipoRaza()->getDetalle()
        ,"idEstadoSalud"=>$listM->getOEstadoSalud()->getIdEstadoSalud()
        ,"detalleEstadoSalud"=>$listM->getOEstadoSalud()->getDetalle());

        return array("status_code"=>200,"datos"=>$listM);
    }
    return array("status_code"=>300,"datos"=>null);
}
?>
