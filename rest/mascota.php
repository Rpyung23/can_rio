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


$json = json_decode(file_get_contents('php://input'),true);



switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        switch($_SERVER['REQUEST_URI'])
        {

            case '/can_rio/rest/mascota.php/todas':

                /**Todos las mascotas ()**/

                echo json_encode(selectM());
                http_response_code(200);
                break;
            case '/can_rio/rest/mascota.php/galeria':

                /**Galeria**/

                echo json_encode(selectG());
                http_response_code(200);
                break;
        }


        break;

    case 'POST':
        $oM = new cMascota();
        $oM->setName($json['name']);
        $oM->setFechaIngreso($json['fecha']);
        $oM->setObservaciones($json['observacion']);
        $oM->setStatus($json['estado']);
        $oM->setEdad($json['edad']);
        $oM->getOTipoRaza()->setIdTipoRaza($json['id_tipo_raza']);
        $oM->getOEstadoSalud()->setIdEstadoSalud($json['id_estado_salud']);
        $oM->setPhoto64($json['photo64']);
        echo json_encode(insertM($oM));
        http_response_code(200);
        break;
    case 'PUT':
        $oMa = new cMascota();
        $oMa->setIdMascota($json['íd_mascota']);
        $oMa->setName($json['name']);
        //$oMa->setFechaIngreso($json['date']);
        $oMa->setObservaciones($json['observaciones']);
        //$oMa->setStatus($json['status']);
        $oMa->setEdad($json['edad']);
        $oMa->getOTipoRaza()->setIdTipoRaza($json['id_tipo_raza']);
        $oMa->getOEstadoSalud()->setIdEstadoSalud($json['id_estado_salud']);


        echo json_encode(updateM($oMa));

        http_response_code(200);


        break;
    case 'DELETE':

        echo json_encode(deleteM($json["id_mascota"]));

        http_response_code(200);

        break;
}


function insertM($oM)
{
    $code = insertMascota($oM);
    return array("status_code"=>$code);
}

function updateM($oM)
{
    $code = updateMascota($oM);
    return array("status_code"=>$code);
}

function deleteM($id)
{
    $code = deleteMascota($id);
    return array("status_code"=>$code);
}

function selectM()
{
    $listM = selectMascotas();

    if($listM!=null)
    {
       for($i = 0 ;$i < sizeof($listM);$i++)
       {
           $listM[$i] = array("idMascota"=>$listM[$i]->getIdMascota()
           ,"name"=>$listM[$i]->getName()
           ,"fecha_ingreso"=>$listM[$i]->getFechaIngreso()
           ,"observaciones"=>$listM[$i]->getObservaciones()
           ,"status"=>$listM[$i]->getStatus()
           ,"edad"=>$listM[$i]->getEdad()
           ,"photo64"=>$listM[$i]->getPhoto64()
           ,"idTipoRaza"=>$listM[$i]->getOTipoRaza()->getIdTipoRaza()
           ,"detalleTipoRaza"=>$listM[$i]->getOTipoRaza()->getDetalle()
           ,"idEstadoSalud"=>$listM[$i]->getOEstadoSalud()->getIdEstadoSalud()
           ,"detalleEstadoSalud"=>$listM[$i]->getOEstadoSalud()->getDetalle());
       }
        return array("status_code"=>200,"datos"=>$listM);
    }
    return array("status_code"=>300,"datos"=>null);
}



function selectG()
{
    $listM = selectGaleria();

    if($listM!=null)
    {
        for($i = 0 ;$i < sizeof($listM);$i++)
        {
            $listM[$i] = array("name"=>$listM[$i]->getName()
            ,"edad"=>$listM[$i]->getEdad()
            ,"photo64"=>$listM[$i]->getPhoto64());
        }
        return array("status_code"=>200,"datos"=>$listM);
    }
    return array("status_code"=>300,"datos"=>null);
}

?>