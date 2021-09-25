<?php
// Customer
require 'classes/customer/Address.php';
require 'classes/customer/Company.php';
require 'classes/customer/Contact.php';
require 'classes/customer/Customer.php';
// Shipment
require 'classes/shipment/Address.php';
require 'classes/shipment/Shipment.php';
// Session
require 'classes/Session.php';
use vezit\classes\shipment as Shipment;
use vezit\classes\customer as Customer;
use vezit\classes as C;


// Customer
$c_address = new Customer\Address("Vinkelvej", "12d 3tv", "2800", "KGS. Lyngby");
$c_contact = new Customer\Contact("26129604", "victor.reipur@gmail.com");
$c_company = new Customer\Company('10007933', 'SGUPS v/Steen Gede');
$c_customer = new Customer\Customer("Victor Reipur", $c_contact, $c_address, $c_company);

// Shipment
$s_address = new Shipment\Address('Jernbanepladsen', '49', '2800', 'KGS. LYNGBY');
$s_shipment = new Shipment\Shipment('12312123', false, $s_address);

// $session_id, $customer, $delivery_info, $order
$session = new C\Session('12345678', $c_customer, $s_shipment, null);

// echo $contact->get_contactInfo() . PHP_EOL;
echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;
