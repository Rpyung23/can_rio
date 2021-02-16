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

if(file_exists('models/cEstadoSalud.php'))
{
    require_once('models/cEstadoSalud.php');
}else
{
    require_once('../models/cEstadoSalud.php');
}

if(file_exists('mysql/tipo_estado_salud_mysql.php'))
{
    require_once('mysql/tipo_estado_salud_mysql.php');
}else
{
    require_once('../mysql/tipo_estado_salud_mysql.php');
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
    $lista = readTipoDonacion();
    $arraysLista = null;
    if($lista != null)
    {
        for($i = 0;$i < sizeof($lista);$i++)
        {
            $arraysLista[$i] = array("id_tipo"=>$lista[$i]->getIdEstadoSalud(),"detalle"=>$lista[$i]->getDetalle());
        }

        return array("status_code"=>200,"datos"=>$arraysLista);
    }

    return array("status_code"=>300,"datos"=>null);
}
?>
