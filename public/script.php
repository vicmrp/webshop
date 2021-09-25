<?php
// Customer
require 'classes/customer/Address.php';
require 'classes/customer/Company.php';
require 'classes/customer/Contact.php';
require 'classes/customer/Customer.php';
// Shipment
require 'classes/shipment/Address.php';
require 'classes/shipment/Shipment.php';
// Order
require 'classes/order/Order.php';
require 'classes/order/Order_Item.php';
require 'classes/order/order_status/Email.php';
require 'classes/order/order_status/Order_Status.php';
require 'classes/order/order_status/Payment.php';
// Session
require 'classes/Session.php';
use vezit\classes\customer as Customer;
use vezit\classes\shipment as Shipment;
use vezit\classes\order as Order;
use vezit\classes\order\order_status as Order_Status;
use vezit\classes as C;


// Customer
$c_address = new Customer\Address(null, null, null, null);
$c_contact = new Customer\Contact(null, null);
$c_company = new Customer\Company(null, null);
$c_customer = new Customer\Customer(null, $c_contact, $c_address, $c_company);

// Shipment
$s_address = new Shipment\Address(null, null, null, null);
$s_shipment = new Shipment\Shipment(null, null, null);

// Order
$o_order_payment = new Order_Status\Payment(null, null, null);
$o_order_email = new Order_Status\Email(null, null);
$o_order_status = new Order_Status\Order_Status($o_order_payment, $o_order_email);

$o_order_item_1 = new Order_Status\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
$o_order_item_2 = new Order_Status\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
$o_list_order_item = [$o_order_item_1,$o_order_item_2];

$o_order = new Order\Order('1234id', $o_order_status, $o_list_order_item);

$session = new C\Session('12345678', $c_customer, $s_shipment, $o_order);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;






// // Customer
// $c_address = new Customer\Address(null, null, null, null);
// $c_contact = new Customer\Contact(null, null);
// $c_company = new Customer\Company(null, null);
// $c_customer = new Customer\Customer(null, $c_contact, $c_address, $c_company);

// // Shipment
// $s_address = new Shipment\Address(null, null, null, null);
// $s_shipment = new Shipment\Shipment(null, null, null);

// // Order
// $o_order_payment = new Order_Status\Payment(null, null, null);
// $o_order_email = new Order_Status\Email(null, null);
// $o_order_status = new Order_Status\Order_Status($o_order_payment, $o_order_email);

// $o_order_item_1 = new Order_Status\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
// $o_order_item_2 = new Order_Status\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
// $o_list_order_item = [$o_order_item_1,$o_order_item_2];

// $o_order = new Order\Order('1234id', $o_order_status, $o_list_order_item);

// $session = new C\Session('12345678', $c_customer, $s_shipment, $o_order);

// echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;
