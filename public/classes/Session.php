<?php
namespace vezit\classes;

class Session implements \JsonSerializable {
  private $session_id;
  public $customer;
  public $shipment;
  public $order;

  public function __construct($session_id, $customer, $shipment, $order) {
    $this->session_id = $session_id;
    $this->customer = $customer;
    $this->shipment = $shipment;
    $this->order = $order;
  }

  public function set_session_id($session_id)
  {
    $this->session_id = $session_id;
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

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
