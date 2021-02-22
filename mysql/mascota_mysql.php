<?php

function insertMascota($oM)
{
    $conn = conexion();
    $sql = "insert into mascota(name,fecha_ingreso,observaciones,status,edad,fk_id_tipo_raza,fk_id_estado_salud,photo) 
            values('".$oM->getName()."',CURDATE()
            ,'".$oM->getObservaciones()."'
            ,".$oM->getStatus().",".$oM->getEdad()."
            ,".$oM->getOTipoRaza()->getIdTipoRaza().",".$oM->getOEstadoSalud()->getIdEstadoSalud()."
            ,'".$oM->getPhoto64()."')";

    mysqli_begin_transaction($conn);

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
    }
    mysqli_commit($conn);
    return 400;

}

function updateMascota($M)
{
    $conn = conexion();
    $sql = "update mascota set name = '".$M->getName()."',
                   observaciones = '".$M->getObservaciones()."',
                   edad = ".$M->getEdad().",fk_id_tipo_raza = ".$M->getOTipoRaza()->getIdTipoRaza().",
                   fk_id_estado_salud = ".$M->getOEstadoSalud()->getIdEstadoSalud()." 
                   where id_mascota = ".$M->getIdMascota();

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
    }

    return 400;
}

function deleteMascota($id)
{
    $conn = conexion();
    $sql = "update mascota set status = 0  where id_mascota = $id";

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
    }

    return 400;
}


function selectGaleria()
{
    $listMascotas = null;
    $cont = 0;

    $conn = conexion();

    $sql = "select M.name,M.edad,M.photo from mascota as M where M.status = 1 and M.fk_id_estado_salud = 2000";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oM = new cMascota();
                //$oM->setIdMascota($lector['id_mascota']);
                $oM->setName($lector['name']);
                //$oM->setFechaIngreso($lector['fecha_ingreso']);
                //$oM->setObservaciones($lector['observaciones']);
                //$oM->setStatus($lector['status']);
                $oM->setEdad($lector['edad']);
                $oM->setPhoto64($lector['photo']);
                //$oM->getOTipoRaza()->setIdTipoRaza($lector['fk_id_tipo_raza']);
                //$oM->getOTipoRaza()->setDetalle($lector['detalle']);
                //$oM->getOEstadoSalud()->setIdEstadoSalud($lector['id_estado_salud']);
                //$oM->getOEstadoSalud()->setDetalle($lector['detalle_estado_salud']);
                $listMascotas[$cont] = $oM;
                $cont++;
            }
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
    }

    return $listMascotas;
}

function selectMascotas()
{
    $listMascotas = null;
    $cont = 0;

    $conn = conexion();

    $sql = "select M.id_mascota,M.name,M.fecha_ingreso,M.observaciones,M.status,
       M.edad,M.fk_id_tipo_raza,M.photo,TR.detalle,Es.id_estado_salud,
       Es.detalle_estado_salud from mascota as M join tipo_raza
           as TR on TR.id_tipo_raza = M.fk_id_tipo_raza
       join estado_salud as Es on Es.id_estado_salud = M.fk_id_estado_salud  where M.status=1";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oM = new cMascota();
                $oM->setIdMascota($lector['id_mascota']);
                $oM->setName($lector['name']);
                $oM->setFechaIngreso($lector['fecha_ingreso']);
                $oM->setObservaciones($lector['observaciones']);
                $oM->setStatus($lector['status']);
                $oM->setEdad($lector['edad']);
                $oM->setPhoto64($lector['photo']);
                $oM->getOTipoRaza()->setIdTipoRaza($lector['fk_id_tipo_raza']);
                $oM->getOTipoRaza()->setDetalle($lector['detalle']);
                $oM->getOEstadoSalud()->setIdEstadoSalud($lector['id_estado_salud']);
                $oM->getOEstadoSalud()->setDetalle($lector['detalle_estado_salud']);
                $listMascotas[$cont] = $oM;
                $cont++;
            }
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
    }

    mysqli_commit($conn);

    return $listMascotas;
}


function selectMascota($id)
{
    $listMascotas = null;

    $conn = conexion();

    $sql = "select M.id_mascota,M.name,M.fecha_ingreso,M.observaciones,M.status,
       M.edad,M.fk_id_tipo_raza,M.photo,TR.detalle,Es.id_estado_salud,
       Es.detalle_estado_salud from mascota as M join tipo_raza
           as TR on TR.id_tipo_raza = M.fk_id_tipo_raza
       join estado_salud as ES on ES.id_estado_salud = M.fk_id_estado_salud  where M.status=1 and M.id_mascota = ".$id;

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            $lector = mysqli_fetch_array($result);

            $oM = new cMascota();

            $oM->setIdMascota($lector['id_mascota']);
            $oM->setName($lector['name']);
            $oM->setFechaIngreso($lector['fecha_ingreso']);
            $oM->setObservaciones($lector['observaciones']);
            $oM->setStatus($lector['status']);
            $oM->setEdad($lector['edad']);
            $oM->setPhoto64($lector['photo']);
            $oM->getOTipoRaza()->setIdTipoRaza($lector['fk_id_tipo_raza']);
            $oM->getOTipoRaza()->setDetalle($lector['detalle']);
            $oM->getOEstadoSalud()->setIdEstadoSalud($lector['id_estado_salud']);
            $oM->getOEstadoSalud()->setDetalle($lector['detalle_estado_salud']);

            $listMascotas = $oM;

        }


    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listMascotas;
    }

    mysqli_commit($conn);

    return $listMascotas;
}

?>