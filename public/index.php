<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 9:59
 */
require_once '../Loader.php';
$requestPath = $_SERVER['REQUEST_URI'];
$tmp = explode('?', $requestPath);
$requestPath = array_shift($tmp);
$path = explode('/', trim($requestPath, '/'));
$className = isset($path[0]) ? ucfirst($path[0]) : 'Home';
$method = isset($path[1]) ? $path[1] : 'show';
unset($path[0]);
unset($path[1]);
$params = [];
if (count($path) > 0) {
    $params = array_values($path);
}

$file = '../app/controller/' . $className . '.class.php';
if (file_exists($file)) {
    require_once $file;
} else {
    require_once '../app/controller/' . 'Home.class.php';
    $className = 'Home';
}

$class = new $className();
$class->run($method, $params);
\core\Logger::accessLog($_SERVER['REQUEST_URI'] . ' ' . $method . '->' . json_encode($params));

