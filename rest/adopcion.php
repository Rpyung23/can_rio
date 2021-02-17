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

if(file_exists('models/cAdopcion.php'))
{
    require_once('models/cAdopcion.php');
}else
{
    require_once('../models/cAdopcion.php');
}

if(file_exists('mysql/adopcion_mysql.php'))
{
    require_once('mysql/adopcion_mysql.php');
}else
{
    require_once('../mysql/adopcion_mysql.php');
}


$json = json_decode(file_get_contents('php://input'),true);
$oAdopcion = new cAdopcion();

switch($_SERVER['REQUEST_METHOD'])
{

    case 'GET':


        switch($_SERVER['REQUEST_URI'])
        {
            case '/can_rio/rest/adopcion.php/todas':

                echo json_encode(allAdopciones());
                http_response_code(200);

                break;
            case '/can_rio/rest/adopcion.php/adoptante':

                echo json_encode(allAdoptacionPorAdoptante($_GET['dni_adoptante']));
                http_response_code(200);

                break;
            case '/can_rio/rest/adopcion.php/fechas':

                echo json_encode(allAdoptacionPorFechas($_GET['fecha_inicio'],$_GET['fecha_fin']));
                http_response_code(200);

                break;
        }


        break;

    case 'PUT':

        echo json_encode(cambioAdopcion($json['id_mascota'],$json['dni_adoptante']));
        http_response_code(200);

        break;

    case 'POST':

        $oAdopcion->getOMascota()->setIdMascota($json['id_mascota']);
        $oAdopcion->getOAdoptante()->getODatosPersonales()->setDni($json['dni_adoptante']);
        $oAdopcion->setFechaAdopcion($json['fecha_adopcion']);
        $oAdopcion->setStatus(1);

        echo json_encode(insertAdo($oAdopcion));

        http_response_code(200);
        break;

    case 'DELETE':

        echo json_encode(deleteAdo($json['id_mascota'],$json['id_adopcion']));
        http_response_code(200);
        break;
}

function allAdoptacionPorFechas($fechaI,$fechaF)
{
    $list = selectAdopcionPorFecha($fechaI,$fechaF);
    $arrays = null;
    if($list!=null)
    {
        for($i = 0 ;$i < sizeof($list) ; $i++)
        {
            $list[$i] = array("id_adopcion"=>$list[$i]->getIdAdopcion()
            ,"fecha_adoptacion"=>$list[$i]->getFechaAdopcion()
            ,"dni_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getDni()
            ,"nombres_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getNombres()
            ,"apellidos_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getApellidos()
            ,"id_mascota"=>$list[$i]->getOMascota()->getIdMascota()
            ,"name_mascota"=>$list[$i]->getOMascota()->getName());
        }

        return array("status_code"=>200,"datos"=>$list);
    }

    return array("status_code"=>300,"datos"=>null);
}

function allAdoptacionPorAdoptante($dni)
{
    $list = selectDatosCompleteAdopcionPorAdoptante($dni);
    $arrays = null;
    if($list!=null)
    {
        for($i = 0 ;$i < sizeof($list) ; $i++)
        {
            $list[$i] = array("id_adopcion"=>$list[$i]->getIdAdopcion()
            ,"fecha_adoptacion"=>$list[$i]->getFechaAdopcion()
            ,"dni_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getDni()
            ,"nombres_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getNombres()
            ,"apellidos_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getApellidos()
            ,"id_mascota"=>$list[$i]->getOMascota()->getIdMascota()
            ,"name_mascota"=>$list[$i]->getOMascota()->getName());
        }

        return array("status_code"=>200,"datos"=>$list);
    }

    return array("status_code"=>300,"datos"=>null);
}

function allAdopciones()
{
    $list = selectAdopciones();
    $arrays = null;
    if($list!=null)
    {
        for($i = 0 ;$i < sizeof($list) ; $i++)
        {
            $list[$i] = array("id_adopcion"=>$list[$i]->getIdAdopcion()
            ,"fecha_adoptacion"=>$list[$i]->getFechaAdopcion()
            ,"dni_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getDni()
            ,"nombres_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getNombres()
            ,"apellidos_adoptante"=>$list[$i]->getOAdoptante()->getODatosPersonales()->getApellidos()
            ,"id_mascota"=>$list[$i]->getOMascota()->getIdMascota()
            ,"name_mascota"=>$list[$i]->getOMascota()->getName());
        }

        return array("status_code"=>200,"datos"=>$list);
    }

    return array("status_code"=>300,"datos"=>null);
}

function insertAdo($oAd)
{
    return array("status_code"=>insertAdopcion($oAd));
}

function deleteAdo($id_mas,$id_ado)
{
    return array("status_code"=>deleteAdopcion($id_mas,$id_ado));
}

function cambioAdopcion($id_,$dni)
{
    return array("status_code"=>updateAdopcion($id_,$dni));
}
?>