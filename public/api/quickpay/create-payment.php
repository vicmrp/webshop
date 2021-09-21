<?php
require '../../library.php';

// Dokumentation - https://learn.quickpay.net/tech-talk/guides/payments/#create-a-new-payment
// 1. Create a new payment
// 2. Authorize payment using a link
// (ikke i brug endnu) 3. Check payment status - kan eventuelt kaldes af callback.php


// Filens/funktionens eksistensgrundlag.
//
// Denne funktion retunere et paymenlink og skal fødes med argumenterne
// params (price, orderID)








// --- bruger/maskin input --- //
$price = 80000;
$orderID = strtolower(generateRandomString(12));
// --- bruger/maskin input --- //









// --- Create a new payment --- //
// Dokumentation se retureksempel secret/flow_example/1_quickpay_createPaymentResponse.json

// Create payment and put information into database generateRandomString(8)
// Det her id er som du laver, og skal bruge som reference til at hænge en ordre op pa den i db.

// url parametre og vars
$apiKey = file_get_contents('../../secret/quickpay_apikey');
$orderID = $orderID;

$createPaymentResponse = shell_exec("curl -u ':$apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$orderID\",\"currency\":\"dkk\"}' https://api.quickpay.net/payments 2> /dev/null");
$createPaymentResponseObj = json_decode($createPaymentResponse);

// retunere payment id, men skal mske valideres først?
$createPaymentResponseObj->id;
// --- Create a new payment --- //









// --- Lav payment link --- //
// Dokumentation se retureksempel secret/flow_example/2_quickpay_createPaymentLinkResponse.json

// url parametetre
// payment_id
$payment_id = $createPaymentResponseObj->id;
$price = $price;


$createPaymentLinkResponse = shell_exec("curl -u ':$apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{\"amount\":\"$price\"}' https://api.quickpay.net/payments/$payment_id/link 2> /dev/null");
$createPaymentLinkObj = json_decode($createPaymentLinkResponse);

// retuner payment link
echo $createPaymentLinkObj->url;

// --- Lav payment link --- //

?>