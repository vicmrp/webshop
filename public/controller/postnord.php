<?php 

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\api\endpoint as E;
use vezit\classes\api\quickpay\Quickpay;
use vezit\classes\error as Error;
use vezit\classes\session as Session;
use vezit\classes\session\order\order_item as Order_Item;
use vezit\services\product_service as Product_Service;
use vezit\services\session_service as Session_Service;
header('Content-Type: application/json; charset=utf-8');





function get_response() : object {

  $required_get_parameters = array('functioncall');
  $endpoint = new E\Endpoint($controller_file_location = __FILE__);
  $endpoint->set_expected_get_parameters($required_get_parameters);
  $session_service = new Session_Service\Session_Service();

  switch ($endpoint->get_parameter->functioncall) {

    case 'get_service_points':

      

      return (object)"Service Points";
      
    default:
      $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
      break;
  }
}

echo json_encode(get_response(), JSON_PRETTY_PRINT);
