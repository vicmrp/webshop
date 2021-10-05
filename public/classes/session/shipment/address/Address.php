<?php
namespace vezit\classes\session\shipment\address;

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

  public function set_street_name($street_name)
  {
    $this->street_name = $street_name;
  }

  public function get_street_name()
  {
    $this->street_name;
  }

  public function set_street_number($street_number)
  {
    $this->street_number = $street_number;
  }

  public function get_street_number()
  {
    # code...
  }

  public function set_postal_code($postal_code)
  {
    $this->postal_code = $postal_code;
  }

  public function get_postal_code()
  {
    # code...
  }

  public function set_city($city)
  {
    $this->city = $city;
  }

  public function get_city()
  {
    # code...
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
