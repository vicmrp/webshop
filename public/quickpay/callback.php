<?php
$privateKey = file_get_contents('../../secret/quickpay_privatkey');

function sign($base, $private_key) {
  return hash_hmac("sha256", $base, $private_key);
}

$request_body = file_get_contents("php://input");
$checksum     = sign($request_body, $privateKey);

if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {

  // Hvis betalingen er gennemført sa gem ordre og lokation samt send email til køber

  // Request is authenticated

  // Hent info om varen ordren og put den i en fil kaldet varenummeret, herefter vedhæft filen til mailen
  
  // echo $request_body;
}



?>