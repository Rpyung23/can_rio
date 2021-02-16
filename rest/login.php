<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if(file_exists('conn/conexion.php'))
{
    require_once('conn/conexion.php');
}else
{
    require_once('../conn/conexion.php');
}

if(file_exists('models/cLogin.php'))
{
    require_once('models/cLogin.php');
}else
{
    require_once('../models/cLogin.php');
}

if(file_exists('mysql/login_mysql.php'))
{
    require_once('mysql/login_mysql.php');
}else
    {
        require_once('../mysql/login_mysql.php');
    }


$json = json_decode(file_get_contents('php://input'),true);

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':

        try
        {
            $oL = new cLogin();
            $oL->setUser($json['user']);
            $oL->setPassw($json['pass']);

            echo json_encode(checkLoginApi($oL));

            http_response_code(200);

        }catch(Exception $exception)
        {
            http_response_code(404);
        }

        break;
}

function checkLoginApi($oLogin)
{
    $code = checkLogin($oLogin);

    return array("status_code"=>$code);
}


?>