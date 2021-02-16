<?php

function readTipoDonacion()
{
    $lista = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select * from tipo_donacion";

    mysqli_begin_transaction($conn);
    mysqli_autocommit($conn,false);

    try
    {
        $result =  mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $Td = new cTipoDonacion();
                $Td->setIdTipoDonacion($lector['id_tipo_donacion']);
                $Td->setDetalle($lector['detalle']);

                $lista[$cont] = $Td;
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