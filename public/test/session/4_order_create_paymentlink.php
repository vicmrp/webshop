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
$order_id = $session->order->get_order_id();


// instansiere quickpay til session
$quickpay = new Quickpay\Quickpay;
// if ($quickpay->get_payment())
// echo var_dump($quickpay->get_payment());

// Hvis der allerede er oprettet en payment session sa 
// if ($quickpay->get_payment() === NULL) {
// Sørg for at tjække om der i forvejen er instantieret en payment session
// };

// total prisen er baseret pa den akumeleret pris
//  af indkøbskurvens indhold
$amount = $session->order->order_status->payment->get_amount();
// echo $amount;
$quickpay->call_set_payment($order_id);
$quickpay->call_get_paymentlink($order_id , $amount);

// Gem session i database / json fil
file_put_contents(_from_top_folder()."/temp/$order_id-session.json", json_encode($session, JSON_PRETTY_PRINT));

// insert_into_database('')
// get_from_database('')

// session
// get by id
// create
$session->create(4444);

// update


// echo payment link til brugeren

echo "<pre>" . $quickpay->get_paymentlink()->url . "</pre>";

// Afslut Sessionen og afvent callback pa om brugeren har betalt eller ej callback-quickpay.json
