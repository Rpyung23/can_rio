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

if(file_exists('models/cVoluntario.php'))
{
    require_once('models/cVoluntario.php');
}else
{
    require_once('../models/cVoluntario.php');
}

if(file_exists('mysql/voluntario_mysql.php'))
{
    require_once('mysql/voluntario_mysql.php');
}else
{
    require_once('../mysql/voluntario_mysql.php');
}


$json = json_decode(file_get_contents('php://input'),true);


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':

        echo json_encode(readVolId($_GET['dni_voluntario']));
        http_response_code(200);
        break;
}

function readVolId($id)
{
    $lisVol =  selectVoluntarioID($id);
    $arraysVol = null;
    if($lisVol!=null)
    {

        $arraysVol = array("dni_voluntario"=>$lisVol->getODatosPersonales()->getDni()
        ,"names"=>$lisVol->getODatosPersonales()->getNombres()
        ,"apes"=>$lisVol->getODatosPersonales()->getApellidos()
        ,"fecha_ingreso"=>$lisVol->getODatosPersonales()->getFecha()
        ,"phone"=>$lisVol->getODatosPersonales()->getPhone()
        ,"email"=>$lisVol->getODatosPersonales()->getEmail()
        ,"dir"=>$lisVol->getODatosPersonales()->getDireccion());

        return array("status_code"=>200,"datos"=>$arraysVol);
    }

    return array("status_code"=>300,"datos"=>null);
}
?>