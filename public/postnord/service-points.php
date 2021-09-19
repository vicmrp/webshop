<?php

$apikey = file_get_contents('../../secret/postnord_apikey');

// --- dawa vask addresse --- //
// Variable input fra brugeren - baseret p av-cables.dk
$userAddressInput = 'Øresundshøj 3a, 2920'; // Vejnavn + husnummer - Vinkelvej 12d, 3tv
$userPostalCodeInput = null; // Postnummer - 2800

$betegnelse = urlencode("$userAddressInput" . ", " . "$userPostalCodeInput");
// DAWA addressevask
// retunere rent addresse objekt
$dawaResponse = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");
// echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
$dawaSanitizedAddress = json_decode($dawaResponse);
// --- dawa vask addresse --- //


// variabler til postnord api
// $countryCode = 'DK';
// $agreementCountry ='DK';
// $city = 'vinkelvej';
// $postalCode = '3210';
// $streetName = 'Lundevej';
// $streetNumber = '15';
// $numberOfServicePoints = 1;




// --- Hent service points --- //
// Documentation 
// https://guides.developer.postnord.com/
// søg pa (ctrl+f) GET Find the nearest service points by address
$countryCode = 'DK';
$agreementCountry = 'DK';
$city = urlencode($dawaSanitizedAddress->resultater[0]->adresse->postnrnavn);
$postalCode = urlencode($dawaSanitizedAddress->resultater[0]->adresse->postnr);
$streetName = urlencode($dawaSanitizedAddress->resultater[0]->adresse->adresseringsvejnavn);
$streetNumber = urlencode($dawaSanitizedAddress->resultater[0]->adresse->husnr);
$numberOfServicePoints = urlencode(10);


// echo "countryCode: $countryCode\nagreementCountry: $agreementCountry\ncity: $city\npostalCode: $postalCode\nstreetName:$streetName\nstreetNumber:$streetNumber\nnumberOfServicePoints: $numberOfServicePoints";

###
$url = "https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&countryCode=$countryCode&agreementCountry=$agreementCountry&city=$city&postalCode=$postalCode&streetName=$streetName&streetNumber=$streetNumber&numberOfServicePoints=$numberOfServicePoints&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public";
// Denne query returnere et json objekt med lokale service points
// navigere stderr 2> /dev/null
$json = shell_exec("curl --location --request GET '$url' 2> /dev/null");

echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
// --- Hent service points --- //