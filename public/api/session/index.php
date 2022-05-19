<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\classes\controller\session_controller\Session_Controller;

$controller = new Session_Controller($_SERVER['REQUEST_METHOD']);
$json = json_encode($controller->get_json_response()->object_to_serialize, JSON_PRETTY_PRINT);
echo $json;