<?php

namespace vezit\services\session_service;

use vezit\classes\session\Session;
use vezit\dto\session\response\Session_Response;
use vezit\classes\session\order\order_item\Order_Item;
use vezit\services\product_service\Product_Service;
use vezit\classes\error\Error;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{

    public function __construct(private Session $session, private Product_Service $product_service)
    {
    }

    public function set_customer_info_from_database(array $customer_info): Session_Response
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



    public function remove_order_item(int $product_id): Session_Response
    {
        // find item in database
        $this->product_service->get_by_id($product_id);

        $this->session->order->remove_order_item($this->product_response->id);

        if (count($this->session->order->get_order_items()) === 0) $this->session->order->order_status->payment->set_amount(0);
        else $this->session->order->order_status->payment->set_accumulated_amount($this->session->order->get_order_items());

        $this->session->set_storing_session_response();
        return $this->get_session();
    }


    public function add_order_item(int $product_id, int $new_quantity): Session_Response
    {

        if ($new_quantity <= 0) {
            $error_message = "quantity cannot not be less than 0. When creating new product-object";
            new Error(__FILE__, $error_message, $fatal_error = true);
        }

        // find item in database
        $this->product_service->get_by_id($product_id);

        // is item already added to object?
        if ($this->session->order->get_order_item($product_id)->order_item === null) {

            $new_order_item = new Order_Item($this->product_reponse->name, $this->product_reponse->id, $this->product_reponse->price, $new_quantity);
            $this->session->order->add_order_item($new_order_item);
        } else {
            $this->session->order->set_change_quantity_order_item($product_id, $new_quantity);
        }
        $this->session->set_storing_session_response();
        return $this->get_session();
    }

    private function customer_is_satisfied(): bool
    {
        if ($this->session->customer->get_fullname() === null) return false;
        if ($this->session->customer->address->get_street() === null) return false;
        if ($this->session->customer->address->get_postal_code() === null) return false;
        if ($this->session->customer->address->get_city() === null) return false;

        return true;
    }

    private function shipment_is_satisfied(): bool
    {
        if ($this->session->shipment->address->get_street_name() === null) return false;
        if ($this->session->shipment->address->get_street_number() === null) return false;
        if ($this->session->shipment->address->get_postal_code() === null) return false;
        if ($this->session->shipment->address->get_city() === null) return false;

        return true;
    }


    private function payment_is_satisfied(): bool
    {
        if (
            $this->session->order->order_status->payment->get_amount() === null ||
            $this->session->order->order_status->payment->get_amount() <= 0
        ) return false;

        return true;
    }


    public function get_session(): Session_Response
    {

        $this->session->customer->set_customer_details_satisfied($this->customer_is_satisfied());
        $this->session->shipment->set_shipment_details_satisfied($this->shipment_is_satisfied());
        $this->session->order->order_status->payment->set_payment_details_satisfied($this->payment_is_satisfied());
        $this->session->set_storing_session_response();

        $session_response = new Session_Response();
        $session_response->session = $this->session;

        return $session_response;
    }

    // destroy session
    public function destroy_session(): Session_Response
    {
        session_destroy();
        $session_response = new Session_Response();
        return $session_response;
    }




    // Funktioner fra vezit\classes\session\Session.php
    public function construct_session_from_repository(object $active_session_response) : void
    {
    $this->session_id = $active_session_response->session->session_id;
    $this->customer->set_customer_details_satisfied($active_session_response->session->customer->customer_details_satisfied);
    $this->customer->set_fullname($active_session_response->session->customer->fullname);
    $this->customer->contact->set_phone($active_session_response->session->customer->contact->phone);
    $this->customer->contact->set_email($active_session_response->session->customer->contact->email);
    $this->customer->address->set_street($active_session_response->session->customer->address->street);
    $this->customer->address->set_postal_code($active_session_response->session->customer->address->postal_code);
    $this->customer->address->set_city($active_session_response->session->customer->address->city);
    $this->customer->company->set_cvr_number($active_session_response->session->customer->company->cvr_number);
    $this->customer->company->set_company_name($active_session_response->session->customer->company->company_name);

    $this->order->set_order_id($active_session_response->session->order->order_id);
    $this->order->order_status->payment->set_accepted($active_session_response->session->order->order_status->payment->accepted);
    $this->order->order_status->payment->set_amount($active_session_response->session->order->order_status->payment->amount);
    $this->order->order_status->payment->set_payment_details_satisfied($active_session_response->session->order->order_status->payment->payment_details_satisfied);
    $this->order->order_status->payment->set_payment_quickpay_id($active_session_response->session->order->order_status->payment->payment_quickpay_id);
    $this->order->order_status->email->set_confirmation_sent($active_session_response->session->order->order_status->email->confirmation_sent);
    $this->order->order_status->email->set_invoice_sent($active_session_response->session->order->order_status->email->invoice_sent);
    foreach ((array)$active_session_response->session->order->order_items as $order_item) {
      $this->order->add_order_item(new Order_Item($order_item->product_name, $order_item->product_id, $order_item->price, $order_item->quantity));
    }

    $this->shipment->set_tracking_number($active_session_response->session->shipment->tracking_number);
    $this->shipment->set_order_collected($active_session_response->session->shipment->order_collected);
    $this->shipment->set_shipment_details_satisfied(true);
    $this->shipment->address->set_street_name($active_session_response->session->shipment->address->street_name);
    $this->shipment->address->set_street_number($active_session_response->session->shipment->address->street_number);
    $this->shipment->address->set_postal_code($active_session_response->session->shipment->address->postal_code);
    $this->shipment->address->set_city($active_session_response->session->shipment->address->city);
  }


  public function get_session_id() : string {
    return $this->session_id;
  }



  public function new_session_id() : string
  {
    while (true)
    {
      if ($this->session_id_is_unique($new_session_id = strval(rand(1000000, 9999999))))
      {
        return $new_session_id;
      }
    }
  }


  private function session_id_is_unique(string $session_id) : bool
  {
    $array_of_session_ids = _scandir(_from_top_folder().'/temp_database/session');
    foreach($array_of_session_ids as $file_session_id)
    {
      if ($session_id == substr($file_session_id, 0, -5)) return false;
    }
    return true;
  }

  public function set_storing_session_response() : void
  {
    $session_response = new Session_Response();
    $session_response->session = $this;
    $json_active_session_response = json_encode($session_response, JSON_PRETTY_PRINT);

    $_SESSION["active_session_response"] = $json_active_session_response;
  }
}
