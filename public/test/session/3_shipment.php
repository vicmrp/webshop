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

// KLIENT Vælg leveringslokation addresse
$street_name = $service_points->servicePointInformationResponse->servicePoints[3]->visitingAddress->streetName;
$street_number = $service_points->servicePointInformationResponse->servicePoints[3]->visitingAddress->streetNumber;
$postal_code = $service_points->servicePointInformationResponse->servicePoints[3]->visitingAddress->postalCode;
$city = $service_points->servicePointInformationResponse->servicePoints[3]->visitingAddress->city;


$session->shipment->address->set_street_name($street_name);
$session->shipment->address->set_street_number($street_number);
$session->shipment->address->set_postal_code($postal_code);
$session->shipment->address->set_city($city);


echo "<pre>" . json_encode($session, JSON_PRETTY_PRINT) . "</pre>";
