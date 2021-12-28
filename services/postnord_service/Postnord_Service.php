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
use vezit\dto\postnord\request as Request;
use vezit\dto\postnord\response as Response;

require __DIR__.'/../../global-requirements.php';

class Postnord_Service
{
  private $session;

  public function __construct() {
    $this->session = new Session\Session();
  }

  public function get_service_points() : Response\Postnord_Service_Points_Response
  {

    $sanitized_address_response = Dawa\Dawa::call_get_sanitized_address(
      (string)$this->session->customer->address->get_street(), 
      (string)$this->session->customer->address->get_postal_code()
    );
    

    $postnord_service_points_request = new Request\Postnord_Service_Points_Request();
    $postnord_service_points_request->sanitized_address_response = $sanitized_address_response;
    $postnord_service_points_response = Postnord\Postnord::call_get_servicepoints($postnord_service_points_request, 2);
    
    return $postnord_service_points_response;
  }
}