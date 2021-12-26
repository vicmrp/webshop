<?php
namespace vezit\_classes\api\quickpay;
require_once __DIR__.'/../../../global-requirements.php';

// php -f _tests/api/quickpay/quickpay_call_get_payments.php


$quickpay = new Quickpay();

echo json_encode($quickpay->call_get_payments(), JSON_PRETTY_PRINT);