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


$apikey = file_get_contents('../../../secret/quickpay_apikey');
$quickpay = new Quickpay\Quickpay($apikey);

// echo $quickpay->get_apikey();
