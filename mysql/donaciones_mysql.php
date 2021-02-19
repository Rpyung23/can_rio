<?php
function insertDonacion($oD)
{
    $conn = conexion();
    $sql = "insert into donaciones(name_donante,fecha_donante,valor,detalle,fk_id_tipo_donacion)
            values ('".$oD->getNameDonante()."',CURDATE()
            ,".$oD->getValor().",'".$oD->getDetalle()."',".$oD->getOTipoDonacion()->getIdTipoDonacion().")";

    mysqli_begin_transaction($conn);

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

    }catch (Exception $e)
    {
        mysqli_rollback($conn);

        return 400;
    }
}

function updateDonacion($oD)
{
    $conn = conexion();
    $sql = "update donaciones set name_donante = '".$oD->getNameDonante()."',fecha_donante = '".$oD->getFechaDonante()."'
                    ,valor = ".$oD->getValor().",detalle = '".$oD->getDetalle()."'
                    ,fk_id_tipo_donacion = ".$oD->getOTipoDonacion()->getIdTipoDonacion()."
                     where id_donacion = ".$oD->getIdDonacion();

    //echo $sql;

    mysqli_begin_transaction($conn);
    try
    {
        if(mysqli_query($conn,$sql))
        {
            mysqli_commit($conn);
            return 200;
        }
    }catch (Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }
    mysqli_commit($conn);
    return 250;
}

function deleteDonacion($idDonacion)
{

}


function selectAllDonaciones()
{
    $listDonaciones = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select *,D.detalle as detalle_dona,TD.detalle as detalleTipo from 
            donaciones as D join tipo_donacion as TD on TD.id_tipo_donacion = D.fk_id_tipo_donacion";

    mysqli_begin_transaction($conn);

    try
    {
        $result = mysqli_query($conn,$sql);
        if($result== true &&mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oD = new cDonaciones();
                $oD->setIdDonacion($lector['id_donacion']);
                $oD->setNameDonante($lector['name_donante']);
                $oD->setFechaDonante($lector['fecha_donante']);
                $oD->setValor($lector['valor']);
                $oD->setDetalle($lector['detalle_dona']);
                $oD->getOTipoDonacion()->setIdTipoDonacion($lector['fk_id_tipo_donacion']);
                $oD->getOTipoDonacion()->setDetalle($lector['detalleTipo']);
                $listDonaciones[$cont] = $oD;
                $cont++;
            }
        }
        mysqli_commit($conn);

    }catch (Exception $e)
    {
        mysqli_rollback($conn);
    }
    return $listDonaciones;
}

function selectAllDonacionIntervalFechas($fechaI,$fechaF)
{
    $listDonaciones = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select *,D.detalle as detalle_dona,TD.detalle as detalleTipo from donaciones as D join tipo_donacion as TD on TD.id_tipo_donacion = D.fk_id_tipo_donacion
              where D.fecha_donante between '".$fechaI."' and '".$fechaF."'";

    mysqli_begin_transaction($conn,MYSQLI_TRANS_START_READ_WRITE);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oD = new cDonaciones();
                $oD->setIdDonacion($lector['id_donacion']);
                $oD->setNameDonante($lector['name_donante']);
                $oD->setFechaDonante($lector['fecha_donante']);
                $oD->setValor($lector['valor']);
                $oD->setDetalle($lector['detalle_dona']);
                $oD->getOTipoDonacion()->setIdTipoDonacion($lector['fk_id_tipo_donacion']);
                $oD->getOTipoDonacion()->setDetalle($lector['detalleTipo']);
                $listDonaciones[$cont] = $oD;
                $cont++;
            }
        }
        mysqli_commit($conn);

    }catch (Exception $e)
    {
        mysqli_rollback($conn);
    }
    return $listDonaciones;
}

function selectValorDonacion($valor)
{
    $listDonaciones = null;
    $cont = 0;
    $conn = conexion();
    $sql = "select *,D.detalle as detalle_dona,TD.detalle as detalleTipo from donaciones 
              as D join tipo_donacion as TD on Td.id_tipo_donacion = D.fk_id_tipo_donacion
              where valor >= ".$valor;

    mysqli_begin_transaction($conn,MYSQLI_TRANS_START_READ_WRITE);

    try
    {
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
            while($lector = mysqli_fetch_array($result))
            {
                $oD = new cDonaciones();
                $oD->setIdDonacion($lector['id_donacion']);
                $oD->setNameDonante($lector['name_donante']);
                $oD->setFechaDonante($lector['fecha_donante']);
                $oD->setValor($lector['valor']);
                $oD->setDetalle($lector['detalle_dona']);
                $oD->getOTipoDonacion()->setIdTipoDonacion($lector['fk_id_tipo_donacion']);
                $oD->getOTipoDonacion()->setDetalle($lector['detalleTipo']);
                $listDonaciones[$cont] = $oD;
                $cont++;
            }
        }
        mysqli_commit($conn);

    }catch (Exception $e)
    {
        mysqli_rollback($conn);
    }
    return $listDonaciones;
}

?>