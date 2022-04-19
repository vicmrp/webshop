<?php

require __DIR__.'/../../global-requirements.php';

use vezit\classes\api\endpoint as E;
use vezit\classes\error as Error;
use vezit\dto\login\request as Login_Request;
use vezit\services\login_service as Service;
use \vezit\repositories\user_repository\User_Repository;

$s_required_get_parameters = array('functioncall');
$s_endpoint = new E\Endpoint($controller_file_location = __FILE__);
$s_endpoint->set_expected_get_parameters($s_required_get_parameters);
$s_login_request = new Login_Request\Login_Request();
$s_login_service = new Service\Login_Service(new User_Repository);

switch ($s_endpoint->get_parameter->functioncall) {

  case 'get_validated_user_credentials':

    $s_endpoint->set_expected_body_properties(array('username', 'password'));
    $s_login_request->username = $s_endpoint->body->username;
    $s_login_request->password = $s_endpoint->body->password;


    $login_response = $s_login_service->validate_user_credentials($s_login_request);
    $response = $login_response;
    break;

  case 'logout':
    $logout_response = $s_login_service->logout();
    $response = $logout_response;
    break;

  case 'check_if_user_is_logged_in':

    $login_response = $s_login_service->check_if_user_is_logged_in();
    $response = $login_response;
    break;

  default:
    $error_message = "Unknown functioncall: " . $s_endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}



header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_PRETTY_PRINT);
