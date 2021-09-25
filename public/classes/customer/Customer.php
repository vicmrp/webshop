<?php
namespace vezit\classes\customer;

class Customer implements \JsonSerializable {
  private $fullname;
  private $contact;
  private $address;
  private $company;


  public function __construct($fullname, $contact, $address, $company) {
    $this->fullname = $fullname;
    $this->contact = $contact;
    $this->address = $address;
    $this->company = $company;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
