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

$oV = new cVoluntario();

switch ($_SERVER['REQUEST_METHOD'])
{
    case 'GET':

        if($_SERVER['REQUEST_URI'] == "/can_rio/rest/voluntario.php/voluntario")
        {
            echo json_encode(readVolId($_GET['dni_voluntario']));
            http_response_code(200);
        }else
            {
                echo json_encode(readVol());
                http_response_code(200);
            }

        break;
    case 'POST':

        $oV->getODatosPersonales()->setNombres($json['name']);
        $oV->getODatosPersonales()->setApellidos($json['ape']);
        $oV->getODatosPersonales()->setDni($json['dni']);
        $oV->getODatosPersonales()->setPhone($json['phone']);
        $oV->getODatosPersonales()->setEmail($json['email']);
        $oV->getODatosPersonales()->setFecha($json['fecha']);
        $oV->getODatosPersonales()->setDireccion($json['dir']);
        $oV->setStatus(1);


        echo json_encode(nuevoVol($oV));

        http_response_code(200);
        break;
    case 'PUT':

        $oV->getODatosPersonales()->setNombres($json['name']);
        $oV->getODatosPersonales()->setApellidos($json['ape']);
        $oV->getODatosPersonales()->setDni($json['dni']);
        $oV->getODatosPersonales()->setPhone($json['phone']);
        $oV->getODatosPersonales()->setEmail($json['email']);
        //$oV->getODatosPersonales()->setFecha($json['fecha']);
        $oV->getODatosPersonales()->setDireccion($json['dir']);

        echo json_encode(updateVol($oV));
        http_response_code(200);

        break;
    case 'DELETE':

        echo json_encode(delVol($json['dni_voluntario']));
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


function nuevoVol($oVol)
{
    $code = insertVoluntario($oVol);
    return array("status_code"=>$code);
}

function readVol()
{
    $lisVol =  selectVoluntario();
    $arraysVol = null;
    if($lisVol!=null)
    {
        for($i = 0;$i < sizeof($lisVol);$i++)
        {
            $arraysVol[$i] = array("dni_voluntario"=>$lisVol[$i]->getODatosPersonales()->getDni()
            ,"names"=>$lisVol[$i]->getODatosPersonales()->getNombres()
            ,"apes"=>$lisVol[$i]->getODatosPersonales()->getApellidos()
            ,"fecha_ingreso"=>$lisVol[$i]->getODatosPersonales()->getFecha()
            ,"phone"=>$lisVol[$i]->getODatosPersonales()->getPhone()
            ,"email"=>$lisVol[$i]->getODatosPersonales()->getEmail()
            ,"dir"=>$lisVol[$i]->getODatosPersonales()->getDireccion());
        }

        return array("status_code"=>200,"datos"=>$arraysVol);
    }

    return array("status_code"=>300,"datos"=>null);
}

function delVol($id)
{
    $code = deleteVoluntario($id);
    return array("status_code"=>$code);
}

function updateVol($oV)
{
    $code = updateVoluntario($oV);
    return array("status_code"=>$code);
}

?>
