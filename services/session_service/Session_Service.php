<?php

namespace vezit\services\session_service;

use vezit\classes\session\Session;
use vezit\dto\session\response\Session_Response;
use vezit\classes\session\order\order_item\Order_Item;
use vezit\services\product_service\Product_Service;
use vezit\classes\error\Error;

require __DIR__.'/../../global-requirements.php';

class Session_Service
{
  public $session;

  public function __construct()
  {
    $this->session = new Session();
  }

  public function set_customer(array $customer_info) : Session_Response
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



  public function remove_order_item($product_id) : Session_Response
  {
      // find item in database
      $product_service = new Product_Service();
      $product_response = $product_service->get_by_id($product_id);

      $this->session->order->remove_order_item($product_response->id);

      if (count($this->session->order->get_order_items()) === 0) $this->session->order->order_status->payment->set_amount(0);
      else $this->session->order->order_status->payment->set_accumulated_amount($this->session->order->get_order_items());

      $this->session->set_storing_session_response();
      return $this->get_session();
  }


  public function add_order_item(int $product_id, int $new_quantity) : Session_Response {

    if ($new_quantity <= 0) {
      $error_message = "quantity cannot not be less than 0. When creating new product-object";
      new Error(__FILE__, $error_message, $fatal_error=true);
    }

    // find item in database
    $product_service = new Product_Service();
    $product_reponse = $product_service->get_by_id($product_id);

    // is item already added to object?
    if ($this->session->order->get_order_item($product_id)->order_item === null) {

      $new_order_item = new Order_Item($product_reponse->name, $product_reponse->id, $product_reponse->price, $new_quantity);
      $this->session->order->add_order_item($new_order_item);

    } else {
      $this->session->order->set_change_quantity_order_item($product_id, $new_quantity);
    }
    $this->session->set_storing_session_response();
    return $this->get_session();
  }

  private function customer_is_satisfied() : bool {
    if ($this->session->customer->get_fullname() === null) return false;
    if ($this->session->customer->address->get_street() === null) return false;
    if ($this->session->customer->address->get_postal_code() === null) return false;
    if ($this->session->customer->address->get_city() === null) return false;

    return true;
  }

  private function shipment_is_satisfied() : bool {
    if ($this->session->shipment->address->get_street_name() === null) return false;
    if ($this->session->shipment->address->get_street_number() === null) return false;
    if ($this->session->shipment->address->get_postal_code() === null) return false;
    if ($this->session->shipment->address->get_city() === null) return false;

    return true;
  }


  private function payment_is_satisfied() : bool {
    if ($this->session->order->order_status->payment->get_amount() === null ||
    $this->session->order->order_status->payment->get_amount() <= 0) return false;

    return true;
  }


  public function get_session() : Session_Response {

    $this->session->customer->set_customer_details_satisfied($this->customer_is_satisfied());
    $this->session->shipment->set_shipment_details_satisfied($this->shipment_is_satisfied());
    $this->session->order->order_status->payment->set_payment_details_satisfied($this->payment_is_satisfied());
    $this->session->set_storing_session_response();

    $session_response = new Session_Response();
    $session_response->session = $this->session;

    return $session_response;
  }

  // destroy session
  public function destroy_session() : Session_Response {
    session_destroy();
    $session_response = new Session_Response();
    return $session_response;
  }
}
