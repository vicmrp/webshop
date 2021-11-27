<?php 

require_once __DIR__.'/../global-requirements.php';

use vezit\_classes\api\endpoint as E;
use vezit\_classes\error as Error;
use vezit\_dto\user\resquest as Request;
use vezit\_services\login_service as Service;

$required_get_parameters = array('functioncall');
$endpoint = new E\Endpoint($controller_file_location = __FILE__);
$endpoint->set_expected_get_parameters($required_get_parameters);



switch ($endpoint->get_parameter->functioncall) {
  case 'get_validated_user_credentials':
    $endpoint->set_expected_body_properties(array('email', 'password'));

    $login_request = new Request\Login_Request();
    $login_request->email = $endpoint->body->email;
    $login_request->password = $endpoint->body->password;

    $login_service = new Service\Login_Service();
    $result = $login_service->validate_user_credentials($login_request);
    break;
  
  default:
    $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}


echo json_encode($result, JSON_PRETTY_PRINT);



// php -f controller/login.php