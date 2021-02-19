<?php

function insertAdoptante($oA)
{
    $conn = conexion();
    $sql = "insert into adoptante(dni, nombres, apellidos, fecha_nacimiento, direccion, phone, email) 
            values('".$oA->getODatosPersonales()->getDni()."'
            ,'".$oA->getODatosPersonales()->getNombres()."'
            ,'".$oA->getODatosPersonales()->getApellidos()."'
            ,'".$oA->getODatosPersonales()->getFecha()."'
            ,'".$oA->getODatosPersonales()->getDireccion()."'
            ,'".$oA->getODatosPersonales()->getPhone()."'
            ,'".$oA->getODatosPersonales()->getEmail()."')";

    //echo $sql;

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }else
        {
            mysqli_commit($conn);
            return 250;
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}

function selectAdoptanteId($id)
{
    $conn = conexion();
    $listAdoptante = null;
    $cont = 0;
    $sql = "select * from adoptante where dni = '".$id."'";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    $result = mysqli_query($conn,$sql);

    try
    {
        if($result== true && mysqli_num_rows($result) > 0)
        {
            $lector = mysqli_fetch_array($result);

            $oAdo = new cAdoptante();


            $oAdo->getODatosPersonales()->setDni($lector['dni']);
            $oAdo->getODatosPersonales()->setNombres($lector['nombres']);
            $oAdo->getODatosPersonales()->setApellidos($lector['apellidos']);
            $oAdo->getODatosPersonales()->setFecha($lector['fecha_nacimiento']);
            $oAdo->getODatosPersonales()->setPhone($lector['phone']);
            $oAdo->getODatosPersonales()->setEmail($lector['email']);
            $oAdo->getODatosPersonales()->setDireccion($lector['direccion']);

            $listAdoptante = $oAdo;

        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listAdoptante;
    }

    mysqli_commit($conn);

    return $listAdoptante;

}

function selectAdoptante()
{
    $conn = conexion();
    $listAdoptante = null;
    $cont = 0;
    $sql = "select * from adoptante";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    $result = mysqli_query($conn,$sql);

    try
    {
        if($result== true && mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oAdo = new cAdoptante();


                $oAdo->getODatosPersonales()->setDni($lector['dni']);
                $oAdo->getODatosPersonales()->setNombres($lector['nombres']);
                $oAdo->getODatosPersonales()->setApellidos($lector['apellidos']);
                $oAdo->getODatosPersonales()->setFecha($lector['fecha_nacimiento']);
                $oAdo->getODatosPersonales()->setPhone($lector['phone']);
                $oAdo->getODatosPersonales()->setEmail($lector['email']);
                $oAdo->getODatosPersonales()->setDireccion($lector['direccion']);

                $listAdoptante[$cont] = $oAdo;
                $cont++;
            }

        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listAdoptante;
    }

    mysqli_commit($conn);
    return $listAdoptante;

}

function deleteAdoptante($id)
{
    $conn = conexion();
    $sql = "update adoptante set status = 0 where dni = ".$id;
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }else
        {
            mysqli_commit($conn);
            return 250;
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}

function updateAdoptante($oAdo)
{
    $conn = conexion();
    $sql = "update adoptante set nombres = '".$oAdo->getODatosPersonales()->getNombres()."'
                    ,apellidos = '".$oAdo->getODatosPersonales()->getApellidos()."'
                    , phone = '".$oAdo->getODatosPersonales()->getPhone()."'
                    , email = '".$oAdo->getODatosPersonales()->getEmail()."'
                    , direccion = '".$oAdo->getODatosPersonales()->getDireccion()."'
              where dni = '".$oAdo->getODatosPersonales()->getDni()."'";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }else
        {
            mysqli_commit($conn);
            return 250;
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }
}

?>