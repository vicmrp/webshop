<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // _from_top_folder().



use vezit\classes\session\customer as Customer;
use vezit\classes\session\shipment as Shipment;
use vezit\classes\session\order as Order;
use vezit\classes\session\order\order_status as Order_Status;
use vezit\classes\session as C;


session_start();

$session = null;


// // Customer
// $c_address = new Customer\Address(null, null, null, null);
// $c_contact = new Customer\Contact(null, null);
// $c_company = new Customer\Company(null, null);
// $c_customer = new Customer\Customer(null, $c_contact, $c_address, $c_company);

// // Shipment
// $s_address = new Shipment\Address(null, null, null, null);
// $s_shipment = new Shipment\Shipment(null, null, null);


// Tilføjer ting til kurven
// // Order
// $o_order_payment = new Order_Status\Payment(null, null, null);
// $o_order_email = new Order_Status\Email(null, null);
// $o_order_status = new Order_Status\Order_Status($o_order_payment, $o_order_email);
// Basket
$o_order_item_1 = new Order_Status\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
$o_order_item_2 = new Order_Status\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
$o_list_order_item = [$o_order_item_1,$o_order_item_2];
// __construct($order_id, $order_status, $order_item)
$o_order = new Order\Order('1234id', null, $o_list_order_item);

// Session
// __construct($session_id, $customer, $shipment, $order)
$session_id = strval(rand(1000000,9999999));
$session = new C\Session($session_id, null, null, $o_order);
$_SESSION["session"] = $session;

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;
