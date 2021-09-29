<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // _from_top_folder().'/


use vezit\classes\session\customer as Customer;
use vezit\classes\session\shipment as Shipment;
use vezit\classes\session\order as Order;
use vezit\classes\session\order\order_status as Order_Status;

session_start();

$session = $_SESSION["session"];



// Customer
$c_address = new Customer\Address("Vinkelvej", "12d 3tv", "2800", "KGS. Lyngby");
$c_contact = new Customer\Contact("26129604", "victor.reipur@gmail.com");
$c_company = new Customer\Company('10007933', 'SGUPS v/Steen Gede');
$c_customer = new Customer\Customer("Victor Reipur", $c_contact, $c_address, $c_company);

$session->set_customer($c_customer);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;

