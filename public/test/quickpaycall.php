<?php
// ----- global ----- //
require_once __DIR__.'/../global-requirements.php'; // _from_top_folder().
use vezit\classes\api\quickpay as Quickpay;


$quickpay = new Quickpay\Quickpay;

$order_id = strval(rand(1000000,9999999));

$quickpay->call_set_payment($order_id);
$quickpay->call_get_paymentlink($order_id , 20000);

echo $quickpay->get_paymentlink()->url;


// echo json_encode(Quickpay\Quickpay::call_set_payment($order_id),JSON_PRETTY_PRINT);


// echo json_encode(Quickpay\Quickpay::call_get_paymentlink($order_id , 20000),JSON_PRETTY_PRINT);