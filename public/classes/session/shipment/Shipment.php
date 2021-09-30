<?php
namespace vezit\classes\session\shipment;

require_once __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\shipment\address as Address;


class Shipment implements \JsonSerializable {
  public $tracking_number;
  public $order_collected;
  public $address;

  public function __construct() {
    $this->address = new Address\Address();
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
