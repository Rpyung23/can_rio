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

switch($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        echo json_encode(allAdoptacionPorFechas($_GET['fecha_inicio'],$_GET['fecha_fin']));
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


?>