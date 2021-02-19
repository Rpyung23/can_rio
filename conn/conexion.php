<?php
function conexion()
{
    $conn = mysqli_connect("localhost","vigitrac_canrio","Puma150012123456789","vigitrac_canrio",3306);
    //$conn = mysqli_connect("localhost","root","","canriobamba",3306);

    if(mysqli_error($conn))
    {
        return null;
    }
    return $conn;
}
?>
