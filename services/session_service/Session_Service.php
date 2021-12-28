<?php

namespace vezit\services\session_service;

use vezit\classes\session as Session;
use vezit\dto\session\response as Session_Response;
use vezit\classes\session\order\order_item as Order_Item;
use vezit\services\product_service as Product_Service;
use vezit\classes\error as Error;
use vezit\services\postnord_service as Postnord_Service;

require __DIR__.'/../../global-requirements.php';

class Session_Service
{
  private $session;

  public function __construct()
  {
    $this->session = new Session\Session();
  }

  public function set_customer(array $customer_info) : Session_Response\Session_Response
  {
    // $customer_info
    $this->session->customer->set_fullname($customer_info['fullname']);
    $this->session->customer->contact->set_phone($customer_info['phone']);
    $this->session->customer->contact->set_email($customer_info['email']);
    $this->session->customer->address->set_street($customer_info['street']);
    $this->session->customer->address->set_postal_code($customer_info['postal_code']);
    $this->session->customer->address->set_city($customer_info['city']);
    $this->session->customer->company->set_cvr_number($customer_info['cvr_number']);
    $this->session->customer->company->set_company_name($customer_info['company_name']);
    $this->session->set_storing_session_response();

    return $this->get_session();

  }

  public function add_order_item(int $product_id, int $new_quantity) : Session_Response\Session_Response {
    
    // find item in database
    $product_service = new Product_Service\Product_Service();
    $product_reponse = $product_service->get_by_id($product_id);

    // is item already added to object?
    if ($this->session->order->get_order_item($product_id)->order_item === null) {

      if ($new_quantity <= 0) {
        $error_message = "quantity cannot not be less than 0. When creating new product-object";
        new Error\Error(__FILE__, $error_message, $fatal_error=false);
        $this->session->set_storing_session_response();
        return $this->get_session();
      }

      $new_order_item = new Order_Item\Order_Item($product_reponse->name, $product_reponse->id, $product_reponse->price, $new_quantity);
      $this->session->order->add_order_item($new_order_item);

    } else {
      $this->session->order->set_change_quantity_order_item($product_id, $new_quantity);
    }
    $this->session->set_storing_session_response();
    return $this->get_session();
  }


  public function get_session() : Session_Response\Session_Response {
    $session_response = new Session_Response\Session_Response();    
    $session_response->session = $this->session;    
    return $session_response;
  }
}
