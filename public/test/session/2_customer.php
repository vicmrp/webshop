<?php
// Customer
require '../../classes/customer/Address.php';
require '../../classes/customer/Company.php';
require '../../classes/customer/Contact.php';
require '../../classes/customer/Customer.php';
// Shipment
require '../../classes/shipment/Address.php';
require '../../classes/shipment/Shipment.php';
// Order
require '../../classes/order/Order.php';
require '../../classes/order/Order_Item.php';
require '../../classes/order/order_status/Email.php';
require '../../classes/order/order_status/Order_Status.php';
require '../../classes/order/order_status/Payment.php';
// Session
require '../../classes/Session.php';
use vezit\classes\customer as Customer;
use vezit\classes\shipment as Shipment;
use vezit\classes\order as Order;
use vezit\classes\order\order_status as Order_Status;
use vezit\classes as C;

session_start();

$session = $_SESSION["session"];

// Customer
$c_address = new Customer\Address("Vinkelvej", "12d 3tv", "2800", "KGS. Lyngby");
$c_contact = new Customer\Contact("26129604", "victor.reipur@gmail.com");
$c_company = new Customer\Company('10007933', 'SGUPS v/Steen Gede');
$c_customer = new Customer\Customer("Victor Reipur", $c_contact, $c_address, $c_company);

$session->set_customer($c_customer);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;

