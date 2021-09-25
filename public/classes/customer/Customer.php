<?php
namespace vezit\classes\customer {
  class Customer {
    public $fullname;
    public $contact;
    public $address;
    public $company;


    public function __construct(string $fullname, $contact, $address, $company) {
      $this->fullname = $fullname;
      $this->contact = $contact;
      $this->address = $address;
      $this->company = $company;
    }
  }
}