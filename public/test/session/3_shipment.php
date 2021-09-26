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

// Shipment
$s_address = new Shipment\Address('Jernbanepladsen', '49', '2800', 'KGS. LYNGBY');
$s_shipment = new Shipment\Shipment('12312123', false, $s_address);

$session->set_shipment($s_shipment);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;