<?php

require __DIR__.'/../../global-requirements.php';

use vezit\classes\api\endpoint\Endpoint;
use vezit\classes\api\quickpay\Quickpay;
use vezit\classes\error\Error;
use vezit\services\login_service\Login_Service;
use vezit\services\quickpay_service\Quickpay_Service;






function get_response() : object {

  $required_get_parameters = array('functioncall');
  $endpoint = new Endpoint($controller_file_location = __FILE__);
  $endpoint->set_expected_get_parameters($required_get_parameters);

  switch ($endpoint->get_parameter->functioncall) {
    case 'get_all_payments':
      // Requires login
      $login_service = new Login_Service();
      if(isset($_SESSION['session_var_active']) === false) {
        $error_message = "session_var_active is not set - you are not logged in.";
        new Error(__FILE__, $error_message, $fatal_error=true);
      }
      $quickpay = new Quickpay();
      return $quickpay->call_get_payments();

    case 'get_payment_by_id':
      // Requires login
      $login_service = new Login_Service();
      if(isset($_SESSION['session_var_active']) === false) {
        $error_message = "session_var_active is not set - you are not logged in.";
        new Error(__FILE__, $error_message, $fatal_error=true);
      }
      $quickpay = new Quickpay();
      $endpoint->set_expected_body_properties(array('id'));

      return $quickpay->call_get_payment_by_id((int)$endpoint->body->id);


    case "create_payment":

      $quickpay_service = new Quickpay_Service();
      return $quickpay_service->create_payment();


    case 'get_payment_link':
      $quickpay_service = new Quickpay_Service();
      return $quickpay_service->get_payment_link();

    default:
      $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
      new Error(__FILE__, $error_message, $fatal_error=true);
      break;
  }

}

header('Content-Type: application/json; charset=utf-8');
$response_object = get_response();
echo json_encode($response_object, JSON_PRETTY_PRINT);

