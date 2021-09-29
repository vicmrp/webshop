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
// API
require '../../classes/api/quickpay/Quickpay.php';

// Session
require '../../classes/Session.php';
// Namespaces
use vezit\classes\api\quickpay as Quickpay;

session_start();

// echo $_SESSION["session"]->get_session_id();
$session = $_SESSION["session"];



// instansiere quickpay til session
$apikey = file_get_contents('../../../secret/quickpay_apikey');
$order_id = strval(rand(1000000,9999999));
$quickpay = new Quickpay\Quickpay($apikey, $order_id);
$session->set_quickpay($quickpay);


// Create a new payment
$session->quickpay->set_payment();
// echo json_encode($quickpay->get_payment(), JSON_PRETTY_PRINT) . PHP_EOL;


// Authorize payment using a link
$price = 11900; // 119 kr
$session->quickpay->set_paymentlink($price);
echo $session->quickpay->get_paymentlink() . PHP_EOL;


// Check payment status
$session->quickpay->set_paymentstatus();
// echo json_encode($quickpay->get_paymentstatus(), JSON_PRETTY_PRINT) . PHP_EOL;

// Betal checkout
$_SESSION["session"] = $session;

// Nar du har betalt modtager du en ordrebekræftelse pa mail