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

if(file_exists('models/cCasosExternos.php'))
{
    require_once('models/cCasosExternos.php');
}else
{
    require_once('../models/cCasosExternos.php');
}

if(file_exists('mysql/casos_externos_mysql.php'))
{
    require_once('mysql/casos_externos_mysql.php');
}else
{
    require_once('../mysql/casos_externos_mysql.php');
}


$json = json_decode(file_get_contents('php://input'),true);
$oC = new cCasosExternos();
switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        echo json_encode(selecF($_GET['fecha_ini'],$_GET['fecha_fin']));
        http_response_code(200);
        break;
}


function selecF($fi,$ff)
{
    $lista = selectCasoFechas($fi,$ff);

    if($lista!=null)
    {
        for($i = 0;$i<sizeof($lista);$i++)
        {
            $lista[$i] = array("id_caso_externo"=>$lista[$i]->getIdCasoExterno()
            ,"fecha_caso"=>$lista[$i]->getFechaCaso()
            ,"direc_principal"=>$lista[$i]->getDirPrincipal()
            ,"direc_secundaria"=>$lista[$i]->getDirSecondary()
            ,"detalle"=>$lista[$i]->getDetalle()
            ,"fk_id_voluntario"=>$lista[$i]->getOVoluntario()->getODatosPersonales()->getDni()
            ,"fk_id_estado_salud_encontrado"=>$lista[$i]->getOEstadoSalud()->getIdEstadoSalud()
            ,"detalle_estado_salud"=>$lista[$i]->getOEstadoSalud()->getDetalle());
        }

        return array("status_code"=>200,"datos"=>$lista);
    }

    return array("status_code"=>300,"datos"=>null);
}


?>