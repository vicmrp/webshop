<?php
namespace vezit\classes\session\customer\address;

class Address implements \JsonSerializable {

  private $street;
  private $postal_code;
  private $city;

  public function __construct() {

  }

  public function set_street($street)
  {
    $this->street = $street;
  }

  public function get_street()
  {
    return $this->street;
  }

  public function set_postal_code($postal_code)
  {
    $this->postal_code = $postal_code;
  }

  public function get_postal_code()
  {
    return $this->postal_code;
  }

  public function set_city($city)
  {
    $this->city = $city;
  }

  public function get_city($city)
  {
    return $this->city;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
