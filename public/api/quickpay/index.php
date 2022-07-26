<?php

//TODO: Delete this file and use session controller instead.
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\controllers\quickpay_controller\Quickpay_Controller;

$url_parameters = $_GET;
$method = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents('php://input');

$controller = new Quickpay_Controller($method, $url_parameters, $body);



(string)$result_in_json = $controller->get_json_response();

echo $result_in_json;
