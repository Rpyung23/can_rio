<?php
function conexion()
{
    $conn = mysqli_connect("localhost","id16147454_root","7tqPx_<-JubYhdzF","id16147454_canriobamba",3306);
    /*$conn = mysqli_connect("localhost","root","","canriobamba",3306);*/

    if(mysqli_error($conn))
    {
        return null;
    }
    return $conn;
}
?>
