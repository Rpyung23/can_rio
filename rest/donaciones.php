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

        //echo $_SERVER['REQUEST_URI'];
        switch($_SERVER['REQUEST_URI'])
        {
            case "/can_rio/rest/donaciones.php/fechas":
                echo json_encode(fechas($_GET['fecha_ini'],$_GET['fecha_fin']));
                break;
            case "/can_rio/rest/donaciones.php/valor":
                echo json_encode(valor($_GET['valor']));
                break;
            case "/can_rio/rest/donaciones.php/todos":
                echo json_encode(todos());
                break;
        }
        http_response_code(200);

        break;
    case 'POST':
        $oDonacion = new cDonaciones();
        $oDonacion->setNameDonante($json['name']);
        $oDonacion->setFechaDonante($json['fecha']);
        $oDonacion->setValor($json['valor']);
        $oDonacion->setDetalle($json['detalle']);
        $oDonacion->getOTipoDonacion()->setIdTipoDonacion($json['id_Tipo_donacion']);
        echo json_encode(insert($oDonacion));
        http_response_code(200);
        break;
    case 'PUT':

        $oD = new cDonaciones();
        $oD->setIdDonacion($json['id_donacion']);
        $oD->setNameDonante($json['name']);
        $oD->setFechaDonante($json['fecha']);
        $oD->setValor($json['valor']);
        $oD->setDetalle($json['detalle']);
        $oD->getOTipoDonacion()->setIdTipoDonacion($json['id_Tipo_donacion']);
        echo json_encode(update($oD));
        http_response_code(200);

        break;
    case 'DELETE':
        break;
}


function insert($oD)
{
    $code = insertDonacion($oD);
    return array("status_code"=>$code);
}

function update($oD)
{
    return array("status_code"=>updateDonacion($oD));
}

function valor($valor)
{
    $list = selectValorDonacion($valor);
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
function todos()
{
    $list = selectAllDonaciones();
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