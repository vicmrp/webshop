<?php
namespace vezit\classes\session\customer;



require_once __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/


use vezit\classes\session\customer\address as Address;
use vezit\classes\session\customer\contact as Contact;
use vezit\classes\session\customer\company as Company;


class Customer implements \JsonSerializable {

  private $fullname;  
  // -- subclasses -- //
  public $address;
  public $contact;
  public $company;
  // -- subclasses -- //

  // public function __construct($fullname, $contact, $address, $company) {
  public function __construct() {

    $this->address = new Address\Address();
    $this->contact = new Contact\Contact();
    $this->company = new Company\Company();

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
