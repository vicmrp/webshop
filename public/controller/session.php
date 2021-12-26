<?php 

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\api\endpoint as E;
use vezit\classes\api\quickpay\Quickpay;
use vezit\classes\error as Error;
use vezit\classes\session as Session;
use vezit\classes\session\order\order_item as Order_Item;
header('Content-Type: application/json; charset=utf-8');





function get_response() : object {

  $required_get_parameters = array('functioncall');
  $endpoint = new E\Endpoint($controller_file_location = __FILE__);
  $endpoint->set_expected_get_parameters($required_get_parameters);

  switch ($endpoint->get_parameter->functioncall) {

    case 'get_session':

      $session = new Session\Session();
      return $session;

    
    case 'add_order_item':
      $endpoint->set_expected_body_properties(array('product_id', 'quantity'));

      $session = new Session\Session();
      $o_order_item_1 = new Order_Item\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
      $session->order->add_order_item($o_order_item_1);
      return $session;


    case 'destroy_session':
      session_destroy();
      return (object)"Session Destroyed";
    
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

echo json_encode(get_response(), JSON_PRETTY_PRINT);
