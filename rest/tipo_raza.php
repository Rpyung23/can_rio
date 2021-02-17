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

if(file_exists('models/cTipoRaza.php'))
{
    require_once('models/cTipoRaza.php');
}else
{
    require_once('../models/cTipoRaza.php');
}

if(file_exists('mysql/tipo_raza_mysql.php'))
{
    require_once('mysql/tipo_raza_mysql.php');
}else
{
    require_once('../mysql/tipo_raza_mysql.php');
}


switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        echo json_encode(selecTipo());
        http_response_code(200);
        break;
}

function selecTipo()
{
    $lista = readTipoRaza();
    $arraysLista = null;
    if($lista != null)
    {
        for($i = 0;$i < sizeof($lista);$i++)
        {
            $arraysLista[$i] = array("id_tipo"=>$lista[$i]->getIdTipoRaza(),"detalle"=>$lista[$i]->getDetalle());
        }

        return array("status_code"=>200,"datos"=>$arraysLista);
    }

    return array("status_code"=>300,"datos"=>null);
}
?>