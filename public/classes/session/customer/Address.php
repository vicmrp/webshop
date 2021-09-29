<?php
namespace vezit\classes\session\customer;

class Address implements \JsonSerializable {

  private $street_name;
  private $street_number;
  private $postal_code;
  private $city;

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

  public function set_street_number($street_number)
  {
    $this->street_number = $street_number;
  }

  public function set_postal_code($postal_code)
  {
    $this->postal_code = $postal_code;
  }

  public function set_city($city)
  {
    $this->city = $city;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
