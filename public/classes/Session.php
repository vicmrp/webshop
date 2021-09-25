<?php
namespace vezit\classes {
  class Session {
    public $session_id;
    public $customer;
    public $shipment;
    public $order;
  
    public function __construct($session_id, $customer, $shipment, $order) {
      $this->session_id = $session_id;
      $this->customer = $customer;
      $this->shipment = $shipment;
      $this->order = $order;
    }
  }
}


