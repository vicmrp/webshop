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

    case 'get_session':
      return $session_service->get_session();

    case 'remove_order_item':
      $endpoint->set_expected_body_properties(array('product_id'));
      $product_id = (int)$endpoint->body->product_id;
      $session_response = $session_service->remove_order_item($product_id);
      return $session_response;

    
    case 'add_order_item':
      $endpoint->set_expected_body_properties(array('product_id', 'quantity'));
      $product_id = (int)$endpoint->body->product_id;
      $quantity = (int)$endpoint->body->quantity;
      $session_response = $session_service->add_order_item($product_id, $quantity);
      return $session_response;

    case 'destroy_session':
      session_destroy();
      return (object)"Session Destroyed";
    
    case 'get_payment_by_id':
      $quickpay = new Quickpay();
      $endpoint->set_expected_body_properties(array('id'));
      return $quickpay->call_get_payment_by_id((int)$endpoint->body->id);

    case 'set_customer':
      $endpoint->set_expected_body_properties(
        array('fullname', 'phone', 'email', 'street', 'postal_code', 'city', 'cvr_number', 'company_name')
      );

      $customer_details = (array)$endpoint->body;
      $session_service->set_customer($customer_details);
      return $session_service->set_customer($customer_details);

    // case: 'get_shipment':
      

    default:
      $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
      break;
  }
}

echo json_encode(get_response(), JSON_PRETTY_PRINT);
