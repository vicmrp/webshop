<?php

// Lav en klasse med bruger info
// Fulde navn

// Session
class Session {
  public $session_id;
  public $customer;
  public $delivery_info;
  public $order;

  public function __construct($session_id, $customer, $delivery_info, $order) {
    $this->session_id = $session_id;
    $this->customer = $customer;
    $this->delivery_info = $delivery_info;
    $this->order = $order;
  }
}



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



  public function set_contact($contact) {
    $this->contact = $contact;
  }

  public function set_company($company) {
    $this->company = $company;
  }
}


class Contact {
  public $phone;
  public $email;

  public function __construct($phone, $email) {
    $this->phone = $phone;
    $this->email = $email;
  }
}

class Address
{
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
}

class Company
{
  public $cvr_number;
  public $company_name;

  public function __construct($cvr_number, $company_name) {
    $this->cvr_number = $cvr_number;
    $this->company_name = $company_name;
  }
}






// __construct($customer, $delivery_info, $order
// __construct(string $fullname, $contact, $address, $company)

$address = new Address("Vinkelvej", "12d 3tv", "2800", "KGS. Lyngby");
$contact = new Contact("26129604", "victor.reipur@gmail.com");
$customer = new Customer("Victor Reipur", $contact, $address, null);


$session = new Session(null, $customer, null, null);
// $customer = new Customer_Info();


// $session->set_contact($contact);

// echo $contact->get_contactInfo() . PHP_EOL;
echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;
