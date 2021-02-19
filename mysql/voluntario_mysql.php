<?php

function insertVoluntario($oV)
{
    $conn = conexion();
    $sql = "insert into voluntario(dni_voluntario, nombres, apellidos, fecha_ingreso, phone, email, direeccion, status) 
            values('".$oV->getODatosPersonales()->getDni()."'
            ,'".$oV->getODatosPersonales()->getNombres()."'
            ,'".$oV->getODatosPersonales()->getApellidos()."'
            ,CURDATE()
            ,'".$oV->getODatosPersonales()->getPhone()."'
            ,'".$oV->getODatosPersonales()->getEmail()."'
            ,'".$oV->getODatosPersonales()->getDireccion()."'
            ,".$oV->getStatus().")";

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

function selectVoluntario()
{
    $conn = conexion();
    $listVoluntarios = null;
    $cont = 0;
    $sql = "select * from voluntario where status = 1";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0)
    {
        while($lector = mysqli_fetch_array($result))
        {
            $oV = new cVoluntario();


            $oV->getODatosPersonales()->setDni($lector['dni_voluntario']);
            $oV->getODatosPersonales()->setNombres($lector['nombres']);
            $oV->getODatosPersonales()->setApellidos($lector['apellidos']);
            $oV->getODatosPersonales()->setFecha($lector['fecha_ingreso']);
            $oV->getODatosPersonales()->setPhone($lector['phone']);
            $oV->getODatosPersonales()->setEmail($lector['email']);
            $oV->getODatosPersonales()->setDireccion($lector['direeccion']);

            $listVoluntarios[$cont] = $oV;
            $cont++;
        }

        return $listVoluntarios;

    }

    return $listVoluntarios;

}

function selectVoluntarioID($id)
{
    $conn = conexion();
    $listVoluntarios = null;
    $cont = 0;
    $sql = "select * from voluntario where status = 1 and dni_voluntario = '".$id."' ";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {

            $lector = mysqli_fetch_array($result);

            $oV = new cVoluntario();

            $oV->getODatosPersonales()->setDni($lector['dni_voluntario']);
            $oV->getODatosPersonales()->setNombres($lector['nombres']);
            $oV->getODatosPersonales()->setApellidos($lector['apellidos']);
            $oV->getODatosPersonales()->setFecha($lector['fecha_ingreso']);
            $oV->getODatosPersonales()->setPhone($lector['phone']);
            $oV->getODatosPersonales()->setEmail($lector['email']);
            $oV->getODatosPersonales()->setDireccion($lector['direeccion']);

            $listVoluntarios = $oV;

        }

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return $listVoluntarios;
    }


    mysqli_commit($conn);

    return $listVoluntarios;

}

function deleteVoluntario($id)
{
    $conn = conexion();
    $sql = "update voluntario set status = 0 where dni_voluntario = ".$id;
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

function updateVoluntario($oV)
{
    $conn = conexion();
    $sql = "update voluntario set nombres = '".$oV->getODatosPersonales()->getNombres()."'
                    ,apellidos = '".$oV->getODatosPersonales()->getApellidos()."'
                    , phone = '".$oV->getODatosPersonales()->getPhone()."'
                    , email = '".$oV->getODatosPersonales()->getEmail()."'
                    , direeccion = '".$oV->getODatosPersonales()->getDireccion()."'
              where dni_voluntario = ".$oV->getODatosPersonales()->getDni();
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
