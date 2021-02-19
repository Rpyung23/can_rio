<?php

function insertAdopcion($oAdopcion)
{
    $conn =  conexion();

    //echo "ID MASCOTA ".$oAdopcion->getOMascota()->getIdMascota();
    $sql_update_mascota = "update mascota set status = 2  where id_mascota = ".$oAdopcion->getOMascota()->getIdMascota();
    $sql_insert_adopcion = "insert into adopcion(fk_id_mascota, fk_dni_adoptante, fecha_adoptacion,status) 
                            values(".$oAdopcion->getOMascota()->getIdMascota()."
                            ,'".$oAdopcion->getOAdoptante()->getODatosPersonales()->getDni()."'
                            ,NOW(),1)";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql_update_mascota))
        {
            if(mysqli_query($conn,$sql_insert_adopcion))
            {
                mysqli_commit($conn);
                return 200;
            }else
                {
                    mysqli_rollback($conn);
                    return 250;
                }
        }else
            {
                mysqli_rollback($conn);
                return 250;
            }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}

function updateAdopcion($id_mascota,$dni_adoptante)
{
    /**CAMBIO ADOPTANTE**/
    $code = 250;
    $conn = conexion();
    $sql = "update adopcion set fk_dni_adoptante  = '".$dni_adoptante."' where fk_id_mascota = ".$id_mascota." and status = 1";


    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql))
        {
            $code = 200;
        }else
            {
                $code = 250;
            }

        mysqli_commit($conn);

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        $code = 400;
    }

    return $code;

}


function selectAdopciones()
{
    $conn = conexion();
    $listaAdopciones = null;
    $cont = 0;
    $sql = "select Ad.id_adopcion,Ad.fecha_adoptacion,Ado.dni,Ado.nombres,Ado.apellidos,M.id_mascota,M.name
       from adopcion as Ad join adoptante as Ado on Ado.dni = Ad.fk_dni_adoptante  join mascota as M on M.id_mascota = Ad.fk_id_mascota
       where Ad.status = 1";
    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);
    try
    {
        $result =  mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $Ado = new cAdopcion();
                $Ado->setIdAdopcion($lector['id_adopcion']);
                $Ado->setFechaAdopcion($lector['fecha_adoptacion']);
                $Ado->getOMascota()->setIdMascota($lector['id_mascota']);
                $Ado->getOMascota()->setName($lector['name']);
                $Ado->getOAdoptante()->getODatosPersonales()->setDni($lector['dni']);
                $Ado->getOAdoptante()->getODatosPersonales()->setNombres($lector['nombres']);
                $Ado->getOAdoptante()->getODatosPersonales()->setApellidos($lector['apellidos']);

                $listaAdopciones[$cont] = $Ado;
                $cont++;

            }
        }
        mysqli_commit($conn);

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
    }

    return $listaAdopciones;
}

function selectDatosCompleteAdopcionPorAdoptante($dni)
{
    $lista = null;
    $cont = 0;
    $conn =  conexion();
    $sql = "select Ad.id_adopcion,Ad.fecha_adoptacion,Ado.dni,Ado.nombres,Ado.apellidos,M.id_mascota,M.name
       from adopcion as Ad join adoptante as Ado on Ado.dni = '".$dni."' join mascota as M on M.id_mascota = Ad.fk_id_mascota
       where Ad.status = 1";

    try
    {
        $result =  mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oAdo = new cAdopcion();

                $oAdo->setIdAdopcion($lector['id_adopcion']);
                $oAdo->setFechaAdopcion($lector['fecha_adoptacion']);
                $oAdo->getOMascota()->setIdMascota($lector['id_mascota']);
                $oAdo->getOMascota()->setName($lector['name']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setDni($lector['dni']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setNombres($lector['nombres']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setApellidos($lector['apellidos']);

                $lista[$cont] = $oAdo;
                $cont++;
            }
        }

        mysqli_commit($conn);
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
    }

    return $lista;

}

function selectAdopcionPorFecha($fechaI,$fechaF)
{
    $lista = null;
    $cont = 0;
    $conn =  conexion();
    $sql = "select Ad.id_adopcion,Ad.fecha_adoptacion,Ado.dni,Ado.nombres,Ado.apellidos,M.id_mascota,M.name
       from adopcion as Ad join adoptante as Ado on Ado.dni = Ad.fk_dni_adoptante  join mascota as M on M.id_mascota = Ad.fk_id_mascota
       where Ad.status = 1 and Ad.fecha_adoptacion between '".$fechaI."' and '".$fechaF."' and Ad.status = 1";

    try
    {
        $result =  mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oAdo = new cAdopcion();

                $oAdo->setIdAdopcion($lector['id_adopcion']);
                $oAdo->setFechaAdopcion($lector['fecha_adoptacion']);
                $oAdo->getOMascota()->setIdMascota($lector['id_mascota']);
                $oAdo->getOMascota()->setName($lector['name']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setDni($lector['dni']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setNombres($lector['nombres']);
                $oAdo->getOAdoptante()->getODatosPersonales()->setApellidos($lector['apellidos']);

                $lista[$cont] = $oAdo;
                $cont++;
            }
        }

        mysqli_commit($conn);
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
    }

    return $lista;

}



function deleteAdopcion($id_mascota,$id_adopcion)
{
    /**1.- update estado mascota**/
    $conn =  conexion();

    //echo "ID MASCOTA ".$oAdopcion->getOMascota()->getIdMascota();
    $sql_update_mascota = "update mascota set status = 1  where id_mascota = ".$id_mascota;
    $sql_insert_adopcion = "update adopcion set status = 0  where id_adopcion = ".$id_adopcion;

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        if(mysqli_query($conn,$sql_update_mascota))
        {
            if(mysqli_query($conn,$sql_insert_adopcion))
            {
                mysqli_commit($conn);
                return 200;
            }else
            {
                mysqli_rollback($conn);
                return 250;
            }
        }else
        {
            mysqli_rollback($conn);
            return 250;
        }
    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}

?>
