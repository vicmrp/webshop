<?php

require_once __DIR__.'/../global-requirements.php';

use vezit\_classes\api\endpoint as E;
use vezit\_classes\error as Error;
use vezit\_classes\session as Session;

$required_get_parameters = array('functioncall');
$endpoint = new E\Endpoint($controller_file_location = __FILE__);
$endpoint->set_expected_get_parameters($required_get_parameters);

switch ($endpoint->get_parameter->functioncall) {
  case 'get_new_session':
    $session = new Session\Session();
    $result = $session;
    break;
  default:
    $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}


echo json_encode($result, JSON_PRETTY_PRINT);
