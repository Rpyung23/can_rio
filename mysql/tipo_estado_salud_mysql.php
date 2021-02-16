<?php

function readTipoDonacion()
{
    $lista = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select * from estado_salud";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result =  mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $Es = new cEstadoSalud();
                $Es->setIdEstadoSalud($lector['id_estado_salud']);
                $Es->setDetalle($lector['detalle_estado_salud']);

                $lista[$cont] = $Es;
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

?>