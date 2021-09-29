<?php
// ----- global ----- //
require __DIR__.'/../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\shipment as Shipment;


session_start();

$session = $_SESSION["session"];

// Shipment
$s_address = new Shipment\Address('Jernbanepladsen', '49', '2800', 'KGS. LYNGBY');
$s_shipment = new Shipment\Shipment('12312123', false, $s_address);

$session->set_shipment($s_shipment);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;