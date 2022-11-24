<?php

require 'vendor/autoload.php';

use Controllers\Home;

function wrongWay()
{
    http_response_code(404);
    include 'page404.php';
}

$URL = $_SERVER["QUERY_STRING"];
if ($URL == null) {
    call_user_func(array(Home::class, 'index'));
} else {
    $urlData = parse_url($URL);
    $urlDataArray = explode('/', $urlData['path']);
    $class = $urlDataArray[0];
    $func = $urlDataArray[1];
    $param = array_splice($urlDataArray, 2);
    $class = ucfirst($class);
    if (file_exists(CONTROLLER_PATH . $class . '.php')) {
        if (method_exists(CONTROLLER_PATH . $class, $func)) {
            echo call_user_func_array(CONTROLLER_PATH . $class . "::" . $func, $param);
        } else {
            wrongWay();
        }
    } else {
        wrongWay();
    }
}