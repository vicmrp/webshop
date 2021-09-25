<?php
namespace vezit\classes;

class Session implements \JsonSerializable {
  private $session_id;
  private $customer;
  private $shipment;
  private $order;

  public function __construct($session_id, $customer, $shipment, $order) {
    $this->session_id = $session_id;
    $this->customer = $customer;
    $this->shipment = $shipment;
    $this->order = $order;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
