<?php
namespace vezit\_classes\api\quickpay;
require_once __DIR__.'/../../../global-requirements.php';

// php -f _tests/api/quickpay/quickpay_call_get_payment_by_id.php


$quickpay = new Quickpay();
$id = 275689149;

echo json_encode($quickpay->call_get_payment_by_id($id), JSON_PRETTY_PRINT);