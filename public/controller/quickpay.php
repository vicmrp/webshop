<?php 

require_once __DIR__.'/../global-requirements.php';

use vezit\_classes\api\endpoint as E;
use vezit\_classes\api\quickpay\Quickpay;
use vezit\_classes\error as Error;
use vezit\_services\login_service as Login_Service;


// Requires login
$login_service = new Login_Service\Login_Service();
if(isset($_SESSION['session_var_active']) === false) {
  $error_message = "session_var_active is not set - you are not logged in.";
  new Error\Error(__FILE__, $error_message, $fatal_error=true);
}




function get_response() : object {

  $required_get_parameters = array('functioncall');
  $endpoint = new E\Endpoint($controller_file_location = __FILE__);
  $endpoint->set_expected_get_parameters($required_get_parameters);

  switch ($endpoint->get_parameter->functioncall) {
    case 'get_all_payments':
      $quickpay = new Quickpay();
      return $quickpay->call_get_payments();
    
    case 'get_payment_by_id':
      $quickpay = new Quickpay();
      
      $endpoint->set_expected_body_properties(array('id'));
      return $quickpay->call_get_payment_by_id((int)$endpoint->body->id);
    default:
      $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
      break;
  }

}

header('Content-Type: application/json; charset=utf-8');
$response_object = get_response();
echo json_encode($response_object, JSON_PRETTY_PRINT);

