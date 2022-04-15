<?php
namespace vezit\classes\session\customer;



require __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/


use vezit\classes\session\customer\address as Address;
use vezit\classes\session\customer\contact as Contact;
use vezit\classes\session\customer\company as Company;


class Customer implements \JsonSerializable {

  private $fullname = null;
  private $customer_details_satisfied = null;
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

  public function set_customer_details_satisfied($customer_details_satisfied) : void {
    $this->customer_details_satisfied = $customer_details_satisfied;
  }

  public function get_customer_details_satisfied() {
    return $this->customer_details_satisfied;
  }

  public function set_fullname($fullname)
  {
    $this->fullname = $fullname;
  }

  public function get_fullname()
  {
    return $this->fullname;
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
