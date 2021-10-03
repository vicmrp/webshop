<?php
// ----- global ----- //
require_once __DIR__.'/../global-requirements.php'; // _from_top_folder().
use vezit\classes\api\quickpay as Quickpay;


echo json_encode(Quickpay\Quickpay::create_newpayment("asdasdasdsad"),JSON_PRETTY_PRINT);
