<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php';

// ----- Namespace ----- //
use vezit\classes\api\quickpay as Quickpay;

$quickpay = new Quickpay\Quickpay;
$request_body = file_get_contents("php://input");

// hvad skal der ske nar call back kaldes?
// Find data / json fil baseret pa ordre_id
// hvis resultatet er falsk sa stop scriptet
if (! ($quickpay->callback($request_body))) {exit(1);}; // exit hvis afsender ikke er fra quickpay
if (! ($quickpay->get_payment()->accepted)) {exit(1);}; // exit hvis betalingen ikke er gennemført

$order_id = $quickpay->get_payment()->order_id;

// Find betalingssessionen
$file_name = 'callback-' . $order_id . '.json';
file_put_contents($file_name, json_encode($quickpay->get_payment(), JSON_PRETTY_PRINT));
// Nar du har betalt modtager du en ordrebekræftelse pa mail

// Hent session 
$session = file_get_contents(_from_top_folder()."/temp/$order_id.json");

file_put_contents('session-' . $order_id . '.json', $session);


?>