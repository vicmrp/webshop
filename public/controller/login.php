<?php

require __DIR__.'/../../global-requirements.php';

use vezit\classes\api\endpoint as E;
use vezit\classes\error as Error;
use vezit\dto\login\request as Login_Request;
use vezit\services\login_service as Service;


$required_get_parameters = array('functioncall');
$endpoint = new E\Endpoint($controller_file_location = __FILE__);
$endpoint->set_expected_get_parameters($required_get_parameters);


switch ($endpoint->get_parameter->functioncall) {

  case 'get_validated_user_credentials':

    $endpoint->set_expected_body_properties(array('username', 'password'));
    $login_request = new Login_Request\Login_Request();
    $login_request->username = $endpoint->body->username;
    $login_request->password = $endpoint->body->password;

    $login_service = new Service\Login_Service();
    $login_response = $login_service->validate_user_credentials($login_request);
    $response = $login_response;
    break;

  case 'logout':
    $login_service = new Service\Login_Service();
    $logout_response = $login_service->logout();
    $response = $logout_response;
    break;

  case 'check_if_user_is_logged_in':
    $login_service = new Service\Login_Service();
    $login_response = $login_service->check_if_user_is_logged_in();
    $response = $login_response;
    break;

  default:
    $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}



header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_PRETTY_PRINT);
