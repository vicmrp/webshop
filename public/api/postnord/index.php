<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\controllers\postnord_controller\Postnord_Controller;

$controller = Postnord_Controller::get_instance(
    $_SERVER['REQUEST_METHOD'],
    $_GET
);
(string)$result_in_json = $controller->get_json_response();

echo $result_in_json;
