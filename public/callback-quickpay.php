<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php';

// ----- Namespace ----- //
use vezit\classes\api\quickpay as Quickpay;
use vezit\classes\mail as Mail;
use vezit\classes\repositories\session as R_Session;

$quickpay = new Quickpay\Quickpay;
$request = file_get_contents("php://input");
$order_id;
$session;
$session_json;
$payment;

if (! ($quickpay->validate($request))) {exit(1);};
if (! ($quickpay->get_payment()->accepted)) {exit(1);};

$payment = $quickpay->get_payment();

$order_id = $payment->order_id;
$session_id = $order_id;


$r_session = new R_Session\Session;

$r_session->update($session_id, $payment);
$session_json = json_encode($r_session->find($session_id), JSON_PRETTY_PRINT);


(array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
(string)$subject = "Bekræftelse på ordre er nr. $order_id";
(string)$body = "<h1>Hello World</h1><pre>$session_json</pre>";
(array)$setFrom = array('dev.victor.reipur@gmail.com', 'Steengede.com');
Mail\Mail::send_mail($recipients, $subject, $body, null, $setFrom);
?>