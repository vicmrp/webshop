<?php
namespace vezit\classes\session\customer;

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

  public function set_fullname($fullname)
  {
    $this->fullname = $fullname;
  }

  public function set_contact($contact)
  {
    $this->contact = $contact;
  }

  public function set_address($address)
  {
    $this->address = $address;
  }

  public function set_company($company)
  {
    $this->company = $company;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
