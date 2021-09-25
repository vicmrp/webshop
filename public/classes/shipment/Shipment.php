<?php
namespace vezit\classes\shipment {
  class Shipment
  {
    public $tracking_number;
    public $order_collected;
    public $address;

    public function __construct($tracking_number, $order_collected, $address) {
      $this->tracking_number = $tracking_number;
      $this->order_collected = $order_collected;
      $this->address = $address;
    }
  }
}


