<?php

namespace vezit\services\postnord_service;

use vezit\classes\session as Session;
use vezit\dto\session\response as Session_Response;
use vezit\classes\session\order\order_item as Order_Item;
use vezit\services\product_service as Product_Service;
use vezit\classes\error as Error;

use vezit\classes\session\shipment as Shipment;
use vezit\classes\session\shipment\address as Address;
use vezit\classes\api\dawa as Dawa;
use vezit\classes\api\postnord as Postnord;


require __DIR__.'/../../global-requirements.php';

class Postnord_Service
{
  private $session;

  public function __construct() {
    $this->session = new Session\Session();
  }

  public function get_service_points()
  {
    $sanitized_address = Dawa\Dawa::call_get_sanitized_address(
      $this->session->customer->address->get_street(),
      $this->session->customer->address->get_postal_code()
    );
  }
}