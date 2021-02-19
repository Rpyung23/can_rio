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

    case 'GET':

        echo json_encode(selectporCanino($_GET['id_canino']));
        http_response_code(200);

        break;
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


?>