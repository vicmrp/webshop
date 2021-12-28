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

  public function get_payment_link()
  {

    // Get total price
    $session = new Session();
    $total_amount = $session->order->payment->get_accumulated_amount();
    $order_id = $session->order->get_order_id();


    $quickpay = new Quickpay();



  }
}