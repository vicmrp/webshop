<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php';

// ----- Namespace ----- //
use vezit\classes\api\quickpay as Quickpay;
use vezit\classes\mail as Mail;

$quickpay = new Quickpay\Quickpay;
$request_body = file_get_contents("php://input");

// hvad skal der ske nar call back kaldes?
// Find data / json fil baseret pa ordre_id
// hvis resultatet er falsk sa stop scriptet
if (! ($quickpay->callback($request_body))) {exit(1);}; // exit hvis afsender ikke er fra quickpay
if (! ($quickpay->get_payment()->accepted)) {exit(1);}; // exit hvis betalingen ikke er gennemført

$order_id = $quickpay->get_payment()->order_id;

// Hent betalingssessionen baseret p ordre id

// Nar du har betalt modtager du en ordrebekræftelse pa mail

// Hent session 
// Hent betalingssessionen baseret p ordre id
$session = json_decode(file_get_contents(_from_top_folder()."/temp/$order_id-session.json"));

// hvis betalingen er true sa set den til true i session databasen og forsæt
if (!($quickpay->get_payment()->accepted)) {exit(1);};

$session->order->order_status->payment->amount = true;

file_put_contents(_from_top_folder()."/temp/$order_id-session.json", json_encode($session, JSON_PRETTY_PRINT));
file_put_contents(_from_top_folder()."/temp/$order_id-callback.json", json_encode($quickpay->get_payment(), JSON_PRETTY_PRINT));

// udsend ordre bekræftelse
  // ----- Eksempel ----- //
  $session_json = json_encode($session, JSON_PRETTY_PRINT);
  (array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
  (string)$subject = "Bekræftelse på ordre er nr. $order_id";
  (string)$body = "<h1>Hello World</h1><pre>$session_json</pre>";
  (array)$setFrom = array('dev.victor.reipur@gmail.com', 'Steengede.com');
  Mail\Mail::send_mail($recipients, $subject, $body, null, $setFrom);
  // ----- Eksempel ----- //
?>