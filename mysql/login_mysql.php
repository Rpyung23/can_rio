<?php

function checkLogin($oL)
{
    $conn = conexion();
    $cont = 0;

    $sql = "select count(*) as contador from login where user = '".$oL->getUser()."' 
            and passw = '".$oL->getPassw()."'";

    mysqli_begin_transaction($conn);
    $conn->autocommit(false);
    try
    {
        $resul = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_array($resul))
        {
            $cont = $row['contador'];
        }

        if($cont>0)
        {
            mysqli_commit($conn);
            return 200;
        }
        mysqli_commit($conn);
        return 300;

    }catch(Exception $e)
    {
        mysqli_rollback($conn);
        return 400;
    }

}
?>
