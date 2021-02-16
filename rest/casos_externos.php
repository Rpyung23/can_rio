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
        if($_SERVER['REQUEST_URI']=="/can_rio/rest/casos_externos.php/fechas")
        {
            echo json_encode(selecF($json['fecha_ini'],$json['fecha_fin']));
            http_response_code(200);
        }else
            {
                echo json_encode(selecAll());
                http_response_code(200);
            }
        break;
    case 'POST':
        $oC->setFechaCaso($json['fecha']);
        $oC->setDirPrincipal($json['dir_p']);
        $oC->setDirSecondary($json['dir_s']);
        $oC->setDetalle($json['detalle']);
        $oC->getOVoluntario()->getODatosPersonales()->setDni($json['dni_volunatrio']);
        $oC->getOEstadoSalud()->setIdEstadoSalud($json['id_estado_salud']);
        echo json_encode(insertCaso($oC));
        http_response_code(200);
        break;
    case 'PUT':

        $oC->setIdCasoExterno($json['id_caso_externo']);
        $oC->setFechaCaso($json['fecha']);
        $oC->setDirPrincipal($json['dir_p']);
        $oC->setDirSecondary($json['dir_s']);
        $oC->setDetalle($json['detalle']);
        //$oC->getOVoluntario()->getODatosPersonales()->setDni($json['dni_volunatrio']);
        //$oC->getOEstadoSalud()->setIdEstadoSalud($json['id_estado_salud']);
        echo json_encode(updateC($oC));
        http_response_code(200);

        break;
    case 'DELETE':
        echo json_encode(delCaso($json['id']));
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


function selecAll()
{
    $lista = selectCasoE();

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

function insertCaso($oCa)
{
    $code = insertCasoE($oCa);
    return array("status_code"=>$code);
}

function delCaso($id)
{
    $code = deleteCasoE($id);
    return array("status_code"=>$code);
}

function updateC($oCa)
{
    $code = updateCasoE($oCa);
    return array("status_code"=>$code);
}

?>