<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // __DIR__._from_top_folder().'/

// Starter sessionen
if (session_status() === PHP_SESSION_NONE) {
  session_start();  
}

// Namespaces
use vezit\classes\api\quickpay as Quickpay;

$session = $_SESSION["session"];
$session_id = $session->get_session_id();
$order_id = $session->order->get_order_id();

// instansiere quickpay til session
$quickpay = new Quickpay\Quickpay;

// total prisen er baseret pa den akumeleret pris
//  af indkøbskurvens indhold
$amount = $session->order->order_status->payment->get_accumulated_amount();
$quickpay->call_set_payment($order_id);
$quickpay->call_get_paymentlink($order_id , $amount);

// Gem session i database / json fil
file_put_contents(_from_top_folder()."/temp_database/session/not_accepted/$session_id.json", json_encode($session, JSON_PRETTY_PRINT));


echo "<pre>" . $quickpay->get_paymentlink()->url . "</pre>";

// Afslut Sessionen og afvent callback pa om brugeren har betalt eller ej callback-quickpay.json