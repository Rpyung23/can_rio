<?php

function insertCasoE($oC)
{
    $conn = conexion();
    $sql = "insert into casos_externos(fecha_caso, direc_principal, direc_secundaria, 
                           detalle, fk_id_voluntario, fk_id_estado_salud_encontrado,status) values 
                   ('".$oC->getFechaCaso()."'
                   ,'".$oC->getDirPrincipal()."'
                   ,'".$oC->getDirSecondary()."'
                   ,'".$oC->getDetalle()."'
                   ,'".$oC->getOVoluntario()->getODatosPersonales()->getDni()."'
                   ,".$oC->getOEstadoSalud()->getIdEstadoSalud().",1)";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }
        mysqli_commit($conn);
        return 250;
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}

function selectCasoE()
{
    $listCasos = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select * from casos_externos as CE  join estado_salud as ES  on CE.fk_id_estado_salud_encontrado = ES.id_estado_salud where CE.status = 1 order by CE.fecha_caso DESC";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $oCE = new cCasosExternos();
                $oCE->setIdCasoExterno($row['id_caso_externo']);
                $oCE->setFechaCaso($row['fecha_caso']);
                $oCE->setDirPrincipal($row['direc_principal']);
                $oCE->setDirSecondary($row['direc_secundaria']);
                $oCE->setDetalle($row['detalle']);
                $oCE->getOVoluntario()->getODatosPersonales()->setDni($row['fk_id_voluntario']);
                $oCE->getOEstadoSalud()->setIdEstadoSalud($row['fk_id_estado_salud_encontrado']);
                $oCE->getOEstadoSalud()->setDetalle($row['detalle_estado_salud']);


                $listCasos[$cont] = $oCE;
                $cont++;
            }
        }

        mysqli_commit($conn);

        return $listCasos;

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listCasos;
    }

}

function updateCasoE($oC)
{
    $conn = conexion();
    $sql = "update casos_externos set fecha_caso = '".$oC->getFechaCaso()."' 
                        , direc_principal = '".$oC->getDirPrincipal()."' 
                        , direc_secundaria = '".$oC->getDirSecondary()."' 
                        , detalle = '".$oC->getDetalle()."' 
                        where id_caso_externo = ".$oC->getIdCasoExterno();
    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }

        mysqli_commit($conn);
        return 250;

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        mysqli_commit($conn);
        return 400;
    }
}

function deleteCasoE($id)
{
    $conn = conexion();
    $sql = "update casos_externos set status = 0 where id_caso_externo = ".$id;
    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }

        mysqli_commit($conn);
        return 250;

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        mysqli_commit($conn);
        return 400;
    }
}



function selectCasoFechas($f1,$f2)
{
    $listCasos = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select * from casos_externos as CE  join estado_salud as ES  
                 on CE.fk_id_estado_salud_encontrado = ES.id_estado_salud 
                 where  fecha_caso between '".$f1."' and '".$f2."' and CE.status = 1 order by CE.fecha_caso DESC";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);

        if($result==true &&  mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $oCE = new cCasosExternos();
                $oCE->setIdCasoExterno($row['id_caso_externo']);
                $oCE->setFechaCaso($row['fecha_caso']);
                $oCE->setDirPrincipal($row['direc_principal']);
                $oCE->setDirSecondary($row['direc_secundaria']);
                $oCE->setDetalle($row['detalle']);
                $oCE->getOVoluntario()->getODatosPersonales()->setDni($row['fk_id_voluntario']);
                $oCE->getOEstadoSalud()->setIdEstadoSalud($row['fk_id_estado_salud_encontrado']);
                $oCE->getOEstadoSalud()->setDetalle($row['detalle_estado_salud']);


                $listCasos[$cont] = $oCE;
                $cont++;
            }
        }

        mysqli_commit($conn);

        return $listCasos;

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listCasos;
    }

}



?>