<?php

namespace vezit\services\quickpay_service;

use vezit\classes\api\dawa\Dawa;
use vezit\classes\api\postnord\Postnord;
use vezit\classes\error\Error;
use vezit\classes\session\Session;
use vezit\classes\session\order\order_item\Order_Item;
use vezit\classes\session\shipment\Shipment;
use vezit\classes\session\shipment\address\Address;
use vezit\dto\postnord\request\Request;
use vezit\dto\postnord\response\Response;
use vezit\dto\session\response\Session_Response;
use vezit\services\product_service\Product_Service;
use vezit\services\session_service\Session_Service;
use vezit\classes\api\quickpay\Quickpay;


require __DIR__.'/../../global-requirements.php';

class Quickpay_Service
{
  private $session_service;

  public function __construct()
  {
    // $this->session = new Session();
    $this->session_service = new Session_Service();
    // die(json_encode($this->session_service->session, JSON_PRETTY_PRINT));
  }

  public function create_payment() : Session_Response
  {
    // $session = new Session();
    // $session_service = new Session_Service();
    
    // $this->session_service->get_session();
    // check if customer details are satisfied

    // echo $session->customer->get_customer_details_satisfied();
    // var_dump($session);
    // echo $session->shipment->get_shipment_details_satisfied();
    // echo $session->order->order_status->payment->get_payment_details_satisfied();

    if  ($this->session_service->session->customer->get_customer_details_satisfied() !== true) 
      new Error(__FILE__, "customer details are not satisfied for payment", $fatal_error=true);

    if  ($this->session_service->session->shipment->get_shipment_details_satisfied() !== true) 
      new Error(__FILE__, "shipment details are not satisfied for payment", $fatal_error=true);

    if  ($this->session_service->session->order->order_status->payment->get_payment_details_satisfied() !== true) 
      new Error(__FILE__, "payment details are not satisfied for payment", $fatal_error=true);

    if ($this->session_service->session->order->order_status->payment->get_payment_quickpay_id() !== null)
      new Error(__FILE__, "payment has already been created", $fatal_error=true);


    $quickpay = new Quickpay();


    echo $this->session_service->session->order->get_order_id();
    $test = $quickpay->call_set_payment($this->session_service->session->order->get_order_id());
    die(var_dump($test));

    $this->session_service->session->order->order_status->payment->set_payment_quickpay_id($this->session_service->session->order->get_order_id());
    $payment_quickpay_id = $quickpay->call_set_payment($this->session_service->session->order->get_order_id())->id;
    $this->session->order->order_status->payment->set_payment_quickpay_id($payment_quickpay_id);

    return $this->session_service->get_session();


    
  }

  public function get_payment_link()
  {

    // Get total price
    $session = new Session();
    $total_amount = $session->order->payment->get_accumulated_amount();
    $order_id = $session->order->get_order_id();


    $quickpay = new Quickpay();



  }
}