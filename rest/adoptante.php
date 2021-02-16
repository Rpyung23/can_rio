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

if(file_exists('models/cAdoptante.php'))
{
    require_once('models/cAdoptante.php');
}else
{
    require_once('../models/cAdoptante.php');
}

if(file_exists('mysql/adoptante_mysql.php'))
{
    require_once('mysql/adoptante_mysql.php');
}else
{
    require_once('../mysql/adoptante_mysql.php');
}


$json = json_decode(file_get_contents('php://input'),true);

$oAdop = new cAdoptante();

switch ($_SERVER['REQUEST_METHOD'])
{
    case 'GET':

        if($_SERVER['REQUEST_URI'] == "/can_rio/rest/adoptante.php/buscar")
        {
            echo json_encode(readAdopId($json['dni']));
            http_response_code(200);
        }else
            {
                echo json_encode(readAdop());
                http_response_code(200);
            }

        break;
    case 'POST':

        $oAdop->getODatosPersonales()->setNombres($json['name']);
        $oAdop->getODatosPersonales()->setApellidos($json['ape']);
        $oAdop->getODatosPersonales()->setDni($json['dni']);
        $oAdop->getODatosPersonales()->setPhone($json['phone']);
        $oAdop->getODatosPersonales()->setEmail($json['email']);
        $oAdop->getODatosPersonales()->setFecha($json['fecha']);
        $oAdop->getODatosPersonales()->setDireccion($json['dir']);


        echo json_encode(nuevoAdop($oAdop));

        http_response_code(200);
        break;
    case 'PUT':

        $oAdop->getODatosPersonales()->setNombres($json['name']);
        $oAdop->getODatosPersonales()->setApellidos($json['ape']);
        $oAdop->getODatosPersonales()->setDni($json['dni']);
        $oAdop->getODatosPersonales()->setPhone($json['phone']);
        $oAdop->getODatosPersonales()->setEmail($json['email']);
        //$oV->getODatosPersonales()->setFecha($json['fecha']);
        $oAdop->getODatosPersonales()->setDireccion($json['dir']);

        echo json_encode(updateAdop($oAdop));
        http_response_code(200);

        break;
    case 'DELETE':

        /*
        echo json_encode(delVol($json['dni_adoptante']));
        http_response_code(200);*/

        break;
}

function readAdopId($id)
{
    $lisVol =  selectAdoptanteId($id);
    $arraysVol = null;
    if($lisVol!=null)
    {
        $arraysVol = array("dni_adoptante"=>$lisVol->getODatosPersonales()->getDni()
        ,"names"=>$lisVol->getODatosPersonales()->getNombres()
        ,"apes"=>$lisVol->getODatosPersonales()->getApellidos()
        ,"fecha_nacimiento"=>$lisVol->getODatosPersonales()->getFecha()
        ,"phone"=>$lisVol->getODatosPersonales()->getPhone()
        ,"email"=>$lisVol->getODatosPersonales()->getEmail()
        ,"dir"=>$lisVol->getODatosPersonales()->getDireccion());

        return array("status_code"=>200,"datos"=>$arraysVol);
    }

    return array("status_code"=>300,"datos"=>null);
}

function nuevoAdop($oA)
{
    $code = insertAdoptante($oA);
    return array("status_code"=>$code);
}

function readAdop()
{
    $lisVol =  selectAdoptante();
    $arraysVol = null;
    if($lisVol!=null)
    {
        for($i = 0;$i < sizeof($lisVol);$i++)
        {
            $arraysVol[$i] = array("dni_adoptante"=>$lisVol[$i]->getODatosPersonales()->getDni()
            ,"names"=>$lisVol[$i]->getODatosPersonales()->getNombres()
            ,"apes"=>$lisVol[$i]->getODatosPersonales()->getApellidos()
            ,"fecha_nacimiento"=>$lisVol[$i]->getODatosPersonales()->getFecha()
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
    $code = deleteAdoptante($id);
    return array("status_code"=>$code);
}

function updateAdop($oAd)
{
    $code = updateAdoptante($oAd);
    return array("status_code"=>$code);
}

?>
