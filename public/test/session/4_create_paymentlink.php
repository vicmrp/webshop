<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // __DIR__._from_top_folder().'/

// Namespaces
use vezit\classes\api\quickpay as Quickpay;

session_start();

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

$quickpay->call_set_payment($order_id);
$quickpay->call_get_paymentlink($order_id , 21300);

// Gem session i database / json fil
file_put_contents(_from_top_folder()."/temp/$order_id.json", json_encode($session, JSON_PRETTY_PRINT));

// echo payment link til brugeren
echo $quickpay->get_paymentlink()->url . PHP_EOL;

// Afslut Sessionen og afvent callback pa om brugeren har betalt eller ej callback-quickpay.json
