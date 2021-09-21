<?php
require_once __DIR__.'/../dawa/datavask.php';

// Filens/funktionens eksistensgrundlag.
//
// retunere et antal servicepoints.
// skal fødes med 'bruger/maskin input'




function postnord_getServicePoints(
$user_address_input, 
$user_postal_code_input = null, 
$number_of_service_points = 10
){

// --- bruger/maskin input --- //
// Variable input fra brugeren - baseret pa av-cables.dk kundeoplysningsformular
// $number_of_service_points = 10;
// $user_address_input = 'Lundevej 15, 3210 Vejby'; // Vejnavn + husnummer - Vinkelvej 12d, 3tv - Øresundshøj 3a, 2920 - Lundevej 15, 3210 Vejby
// $user_postal_code_input = null; // Postnummer - 2800
// --- bruger/maskin input --- //









// --- dawa vask addresse --- //
$dawa_sanitized_address = json_decode(datavask($user_address_input, $user_postal_code_input));
// $betegnelse = urlencode("$user_address_input" . ", " . "$user_postal_code_input");
// $dawa_response = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");
// $dawa_sanitized_address = json_decode($dawa_response);
// --- dawa vask addresse --- //









// --- Hent service points --- //
// Documentation 
// https://guides.developer.postnord.com/
// søg pa (ctrl+f) GET Find the nearest service points by address


// Tager dawas retur objekt og putter dem ind i relevante fælter i postnord request
$country_code = 'DK';
$agreement_country = 'DK';
$city = urlencode($dawa_sanitized_address->resultater[0]->adresse->postnrnavn);
$postal_code = urlencode($dawa_sanitized_address->resultater[0]->adresse->postnr);
$street_name = urlencode($dawa_sanitized_address->resultater[0]->adresse->adresseringsvejnavn);
$street_number = urlencode($dawa_sanitized_address->resultater[0]->adresse->husnr);
$number_of_service_points = urlencode(10);



$apikey = file_get_contents('../../../secret/postnord_apikey');
$url = "https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&countryCode=$country_code&agreementCountry=$agreement_country&city=$city&postalCode=$postal_code&streetName=$street_name&streetNumber=$street_number&numberOfServicePoints=$number_of_service_points&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public";

// Returnere et json objekt med lokale service points
$json = shell_exec("curl --location --request GET '$url' 2> /dev/null"); // navigere stderr 2> /dev/null

return json_encode(json_decode($json), JSON_PRETTY_PRINT);
// --- Hent service points --- //
}


// echo postnord_getServicePoints("Vinkelvej 12D, 3tv", 2800, 1);

// echo __DIR__;