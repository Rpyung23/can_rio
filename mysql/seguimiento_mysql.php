<?php
function insertSeguimiento($oS)
{
    $conn = conexion();

    $sql = "insert into seguimiento(fk_id_adopcion, fk_id_voluntario, fecha_seguimiento, observaciones)
             values(".$oS->getOAdopcion()->getIdAdopcion().",'".$oS->getOVoluntario()->getODatosPersonales()->getDni()."'
             ,'".$oS->getFecha()."','".$oS->getObservaciones()."')";

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

function selectSeguimientoCanino($id_canino)
{
    $lista = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select S.id_seguimiento,S.fk_id_adopcion,S.fecha_seguimiento,S.observaciones,V.dni_voluntario
     ,V.nombres,V.apellidos,M.id_mascota,M.name,M.photo
       from seguimiento as S join voluntario as V on S.fk_id_voluntario = V.dni_voluntario
           join adopcion Ad on Ad.id_adopcion = S.fk_id_adopcion join mascota as M on M.id_mascota = ".$id_canino;

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oS = new cSeguimiento();
                $oS->setIdSeguimiento($lector['id_seguimiento']);
                $oS->setFecha($lector['fecha_seguimiento']);
                $oS->setObservaciones($lector['observaciones']);
                $oS->getOAdopcion()->setIdAdopcion($lector['fk_id_adopcion']);
                $oS->getOVoluntario()->getODatosPersonales()->setDni($lector['dni_voluntario']);
                $oS->getOVoluntario()->getODatosPersonales()->setNombres($lector['nombres']);
                $oS->getOVoluntario()->getODatosPersonales()->setApellidos($lector['apellidos']);
                $oS->getOMascota()->setIdMascota($lector['id_mascota']);
                $oS->getOMascota()->setName($lector['name']);
                $oS->getOMascota()->setPhoto64($lector['photo']);
                $lista[$cont] = $oS;
                $cont++;
            }
        }
        mysqli_commit($conn);

    }catch(Exception $e)
    {
        return $lista;
    }

    return $lista;
}


function selectSeguimientos()
{
    $lista = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select S.id_seguimiento,S.fk_id_adopcion,S.fecha_seguimiento,S.observaciones,V.dni_voluntario,V.nombres,v.apellidos
       from seguimiento as S join voluntario as V on S.fk_id_voluntario = V.dni_voluntario order by S.fecha_seguimiento DESC";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oS = new cSeguimiento();
                $oS->setIdSeguimiento($lector['id_seguimiento']);
                $oS->setFecha($lector['fecha_seguimiento']);
                $oS->setObservaciones($lector['observaciones']);
                $oS->getOAdopcion()->setIdAdopcion($lector['fk_id_adopcion']);
                $oS->getOVoluntario()->getODatosPersonales()->setDni($lector['dni_voluntario']);
                $oS->getOVoluntario()->getODatosPersonales()->setNombres($lector['nombres']);
                $oS->getOVoluntario()->getODatosPersonales()->setApellidos($lector['apellidos']);
                $lista[$cont] = $oS;
                $cont++;
            }
        }
        mysqli_commit($conn);

    }catch(Exception $e)
    {
        return $lista;
    }

    return $lista;

}

?>
