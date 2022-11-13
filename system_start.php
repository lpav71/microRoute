<?php
spl_autoload_register(function ($class) {
    include $class . '.php';
});
function wrongWay(){
    http_response_code(404);
    include 'page404.php';
}

$URL = $_SERVER["QUERY_STRING"];
if ($URL == null) {
    call_user_func(CONTROLLER_PATH.'home::index');
}
else {
    $urlData = parse_url($URL);
    $urlDataArray = explode('/', $urlData['path']);
    $class = $urlDataArray[0];
    $func = $urlDataArray[1];
    $param = array_splice($urlDataArray, 2);
    if (file_exists ('Controllers/' . $class . '.php')){
        if (method_exists(CONTROLLER_PATH . $class, $func)){
            echo call_user_func_array(CONTROLLER_PATH . $class . "::" . $func, $param);
        }
        else wrongWay();
    }
    else wrongWay();
}