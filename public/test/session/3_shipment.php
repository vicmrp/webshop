<?php
// ----- global ----- //
require __DIR__.'/../../../global-requirements.php'; // g_from_top_folder().'/

// Starter sessionen
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


use vezit\classes\session\shipment as Shipment;
use vezit\classes\session\shipment\address as Address;
use vezit\classes\api\dawa as Dawa;
use vezit\classes\api\postnord as Postnord;


$session = $_SESSION["session"];

// SERVER Indsend brugerens addresse til postnord API
$sanitized_address = Dawa\Dawa::call_get_sanitized_address($session->customer->address->get_street(), $session->customer->address->get_postal_code());
// echo "<pre>" . json_encode($sanitized_address , JSON_PRETTY_PRINT) . "</pre>"; die();

// SERVER Fa service points return
$service_points = Postnord\Postnord::call_get_servicepoints($sanitized_address);
// echo "<pre>" . json_encode($service_points , JSON_PRETTY_PRINT) . "</pre>"; die();



// KLIENT Vælg leveringslokation addresse
$street_name = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->streetName;
$street_number = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->streetNumber;
$postal_code = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->postalCode;
$city = $service_points->servicePointInformationResponse->servicePoints[0]->visitingAddress->city;


$session->shipment->address->set_street_name($street_name);
$session->shipment->address->set_street_number($street_number);
$session->shipment->address->set_postal_code($postal_code);
$session->shipment->address->set_city($city);

echo "<pre>" . json_encode($session, JSON_PRETTY_PRINT) . "</pre>";
