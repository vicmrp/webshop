<?php
namespace vezit\classes\customer;

class Contact implements \JsonSerializable {
  private $phone;
  private $email;

  public function __construct($phone, $email) {
    $this->phone = $phone;
    $this->email = $email;
  }

  public function set_phone($phone)
  {
    $this->phone = $phone;
  }

  public function set_email($email)
  {
    $this->email = $email;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}