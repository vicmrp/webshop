<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().'/


use vezit\classes\session\shipment as Shipment;
use vezit\classes\session\shipment\address as Address;
use vezit\classes\api\dawa as Dawa;
use vezit\classes\api\postnord as Postnord;

session_start();

$session = $_SESSION["session"];

// SERVER Indsend brugerens addresse til postnord API
$sanitized_address = Dawa\Dawa::call_get_sanitized_address($session->customer->address->get_street(), '2920');

// SERVER Fa service points retur
$service_points = Postnord\Postnord::call_get_servicepoints($sanitized_address);
// var_dump($service_points->servicePointInformationResponse);
// exit;
// KLIENT Vælg leveringslokation addresse
$street_name = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->streetName;
$street_number = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->streetNumber;
$postal_code = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->postalCode;
$city = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->city;

// // Shipment
$s_address = new Shipment\Address('Jernbanepladsen', '49', '2800', 'KGS. LYNGBY');
$s_shipment = new Shipment\Shipment(null, false, $s_address);

$session->set_shipment($s_shipment);

echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;