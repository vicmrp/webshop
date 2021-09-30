<?php
namespace vezit\classes\session;

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

class Session implements \JsonSerializable {

  
  private $session_id;
  // -- subclasses -- //
  public $customer;
  public $order;
  public $shipment;
  // -- subclasses -- //

  public function __construct() {
  


    // -- subclasses -- //
    $this->customer = new Customer\Customer();
    $this->order = new Order\Order();
    $this->shipment = new Shipment\Shipment();
    // -- subclasses -- //
  }

  public function set_session_id($session_id)
  {
    $this->session_id = $session_id;
  }

  public function get_session_id()
  {
    return $this->session_id;
  }

  public function set_customer($customer)
  {
    $this->customer = $customer;
  }

  public function set_shipment($shipment)
  {
    $this->shipment = $shipment;
  }

  public function set_order($order)
  {
    $this->order = $order;
  }

  public function set_quickpay($quickpay)
  {
    $this->quickpay = $quickpay;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
