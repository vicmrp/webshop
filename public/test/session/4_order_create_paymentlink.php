<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // __DIR__._from_top_folder().'/

// Starter sessionen
if (session_status() === PHP_SESSION_NONE) {
  session_start();  
}

// Namespaces
use vezit\classes\api\quickpay as Quickpay;
use vezit\classes\repositories\session as R_Session;

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

$r_session = new R_Session\Session;
$r_session->insert($session);

echo "<pre>" . $quickpay->get_paymentlink()->url . "</pre>";

// Afslut Sessionen og afvent callback pa om brugeren har betalt eller ej callback-quickpay.json