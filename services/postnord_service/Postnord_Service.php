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
use vezit\services\session_service as Session_Service;

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
    $postnord_service_points_response = Postnord\Postnord::call_get_servicepoints($postnord_service_points_request);
    $_SESSION['postnord_service_points_response'] = json_encode($postnord_service_points_response ,JSON_PRETTY_PRINT);

    return $postnord_service_points_response;
  }

  public function set_shipment_address($index) : Session_Response\Session_Response
  {
    if(isset($_SESSION['postnord_service_points_response']) === false) {
      $error_message = "Session variable: postnord_service_points_response does not exist";
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
    }

    $postnord_service_points_response = new Response\Postnord_Service_Points_Response();
    $postnord_service_points_response->service_points = json_decode($_SESSION['postnord_service_points_response'])->service_points;

    

    
    foreach($postnord_service_points_response->service_points as $shipment_address)  {
      if ($shipment_address->index === $index) {
        $this->session->shipment->address->set_street_name($shipment_address->street_name);
        $this->session->shipment->address->set_street_number($shipment_address->street_number);
        $this->session->shipment->address->set_postal_code($shipment_address->postal_code);
        $this->session->shipment->address->set_city($shipment_address->city);
        $this->session->set_storing_session_response();

        $session_service = new Session_Service\Session_Service();
        return  $session_service->get_session();
      }
    }
    
    $error_message = "index is out of range. index: $index";
    new Error\Error(__FILE__, $error_message, $fatal_error=true);

  }
}