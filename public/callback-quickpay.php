<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php';

// ----- Namespace ----- //
use vezit\classes\api\quickpay as Quickpay;

$quickpay = new Quickpay\Quickpay;
$request_body = file_get_contents("php://input");

// hvis resultatet er falsk sa stop scriptet
if (!$quickpay->callback($request_body)) {exit(1);};

$payment_status = $quickpay->get_payment();
$file_name = 'result-' . $payment_status->id . '.json';

// hvad skal der ske nar call back kaldes?
file_put_contents($file_name, json_encode($payment_status, JSON_PRETTY_PRINT))


?>