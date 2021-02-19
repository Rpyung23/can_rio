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

if(file_exists('models/cDonaciones.php'))
{
    require_once('models/cDonaciones.php');
}else
{
    require_once('../models/cDonaciones.php');
}

if(file_exists('mysql/donaciones_mysql.php'))
{
    require_once('mysql/donaciones_mysql.php');
}else
{
    require_once('../mysql/donaciones_mysql.php');
}


$json = json_decode(file_get_contents('php://input'),true);

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':

        echo json_encode(fechas($_GET['fecha_ini'],$_GET['fecha_fin']));
        http_response_code(200);

        break;


}


function fechas($init,$end)
{
    $list = selectAllDonacionIntervalFechas($init,$end);
    $arrays = null;
    if($list!=null)
    {
        for($i = 0;$i< sizeof($list);$i++)
        {
            $arrays[$i] = array("id_donacion"=>$list[$i]->getIdDonacion()
            ,"name_donante"=>$list[$i]->getNameDonante()
            ,"fecha_donante"=>$list[$i]->getFechaDonante()
            ,"valor"=>$list[$i]->getValor()
            ,"detalleDonacion"=>$list[$i]->getDetalle()
            ,"id_tipo_donacion"=>$list[$i]->getOTipoDonacion()->getIdTipoDonacion()
            ,"detalleTipoDonacion"=>$list[$i]->getOTipoDonacion()->getDetalle());
        }

        return array("status_code"=>200,"datos"=>$arrays);
    }

    return array("status_code"=>300,"datos"=>null);
}

?>