<?php
namespace vezit\classes\session\shipment;

class Address implements \JsonSerializable {
  public $street_name;
  public $street_number;
  public $postal_code;
  public $city;
  
  public function __construct($street_name, $street_number, $postal_code, $city) {
    $this->street_name = $street_name;
    $this->street_number = $street_number;
    $this->postal_code = $postal_code;
    $this->city = $city;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
