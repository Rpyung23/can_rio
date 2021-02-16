<?php

function readTipoRaza()
{
    $lista = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select * from tipo_raza";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result =  mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $Tr = new cTipoRaza();
                $Tr->setIdTipoRaza($lector['id_tipo_raza']);
                $Tr->setDetalle($lector['detalle']);

                $lista[$cont] = $Tr;
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