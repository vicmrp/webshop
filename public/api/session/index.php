<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\controllers\session_controller\Session_Controller;

$url_parameters = $_GET;
$method = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents('php://input');

$controller = new Session_Controller($method, $url_parameters, $body);



(string)$result_in_json = $controller->get_json_response();

echo $result_in_json;
