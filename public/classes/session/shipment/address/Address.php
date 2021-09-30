<?php
namespace vezit\classes\session\shipment\address;

class Address implements \JsonSerializable {
  public $street_name;
  public $street_number;
  public $postal_code;
  public $city;
  
  public function __construct() {

  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
