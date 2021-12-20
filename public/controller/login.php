<?php 

require_once __DIR__.'/../global-requirements.php';

use vezit\_classes\api\endpoint as E;
use vezit\_classes\error as Error;
use vezit\_dto\login\resquest as Login_Request;
use vezit\_services\login_service as Service;

$required_get_parameters = array('functioncall');
$endpoint = new E\Endpoint($controller_file_location = __FILE__);
$endpoint->set_expected_get_parameters($required_get_parameters);



switch ($endpoint->get_parameter->functioncall) {
  case 'get_validated_user_credentials':
    $endpoint->set_expected_body_properties(array('username', 'password'));

    $login_request = new Login_Request\Login_Request();
    $login_request->username = $endpoint->body->username;
    $login_request->identity = $endpoint->body->password;
    $login_request->groupmember = 'byg-it-afd';

    $login_service = new Service\Login_Service();
    $login_response = $login_service->validate_user_credentials($login_request);
    $response = $login_response;
    break;

  case 'varify_user_and_start_login_session_if_varified':
    $endpoint->set_expected_body_properties(array('username', 'password'));
    $login_request = new Login_Request\Login_Request();
    $login_request->username = $endpoint->body->username;
    $login_request->identity = $endpoint->body->password;
    $login_request->groupmember = 'byg-it-afd';

    $login_service = new Service\Login_Service();
    $login_response = $login_service->validate_user_credentials($login_request);
    $login_response->login_session_response_isset = ($login_service->set_login_session_response($login_response)) ? true : false;

    // if ($login_response->varified) { 
    //   $login_response->session_status_active = (session_status() === PHP_SESSION_ACTIVE) ? true : false;

    //   $login_response->session_variable_isset = isset($_SESSION['login_session']);
    //   $_SESSION['login_session'] = $login_response;
    // }
    $response = $login_response;
    
    break;

    case 'get_login_session_response':
      $login_service = new Service\Login_Service();
      return $login_service->get_login_session_response();
      // $response = json_decode('{"test":"HelloWorld"}');
      break;
  default:
    $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}


echo json_encode($response, JSON_PRETTY_PRINT);
