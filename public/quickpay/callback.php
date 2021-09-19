<?php


// Dokumentation - https://learn.quickpay.net/tech-talk/api/callback/#callback
// Se et callback eksempel secret/flow_example/3_quickpay_callback.json
// Denne funktions inputs kommer fra quickpay nr en kunde har betalt



function sign($base, $private_key) {
  return hash_hmac("sha256", $base, $private_key);
}

$request_body = file_get_contents("php://input");
$privateKey = file_get_contents('../../secret/quickpay_privatkey');
$checksum     = sign($request_body, $privateKey);


if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {
  // Handter betaling
  
  // Hvis betalingen er gennemført sa gem ordre og lokation samt send email til køber
  
  // Request is authenticated

  // Hent info om varerordren og put den i en fil kaldet varenummeret, herefter vedhæft filen til mailen.

}



?>