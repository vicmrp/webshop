<?php
namespace vezit\classes\session\shipment;

require_once __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\shipment\address as Address;


class Shipment implements \JsonSerializable {
  private $tracking_number;
  private $order_collected;
  public $address;

  public function __construct() {
    $this->address = new Address\Address(null, null, null, null);
  }


  // ----- private $tracking_number ----- //
  public function set_tracking_number($tracking_number) {
    $this->tracking_number = $tracking_number;
  }

  public function get_tracking_number($tracking_number) {
    $this->tracking_number = $tracking_number;
  }
  // ----- private $tracking_number ----- //


  // ----- private $order_collected ----- //
  public function set_order_collected($order_collected) {
    $this->order_collected = $order_collected;
  }

  public function get_order_collected($order_collected) {
    $this->order_collected = $order_collected;
  }
  // ----- private $order_collected ----- //


  // ----- private $address ----- //
  public function set_address($address) {
    $this->address = $address;
  }

  public function get_address($address) {
    $this->address = $address;
  }
  // ----- private $address ----- //


  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
    $vars = get_object_vars($this);
    return $vars;
  }
}
