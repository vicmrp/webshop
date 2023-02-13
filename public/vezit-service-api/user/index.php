<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\controllers\user_controller\User_Controller;

$json_response =  User_Controller::get_instance(
    $request_method = $_SERVER['REQUEST_METHOD'],
    $url_parameters = $_GET,
    $body = file_get_contents('php://input'))->get_json_response();

echo $json_response;
