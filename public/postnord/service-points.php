<?php




// --- bruger/maskin input --- //
// Variable input fra brugeren - baseret pa av-cables.dk kundeoplysningsformular 
$userAddressInput = 'Øresundshøj 3a, 2920'; // Vejnavn + husnummer - Vinkelvej 12d, 3tv
$userPostalCodeInput = null; // Postnummer - 2800
// --- bruger/maskin input --- //









// --- dawa vask addresse --- //
$betegnelse = urlencode("$userAddressInput" . ", " . "$userPostalCodeInput");
$dawaResponse = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");
$dawaSanitizedAddress = json_decode($dawaResponse);
// --- dawa vask addresse --- //









// --- Hent service points --- //
// Documentation 
// https://guides.developer.postnord.com/
// søg pa (ctrl+f) GET Find the nearest service points by address


// Tager dawas retur objekt og putter dem ind i relevante fælter i postnord request
$countryCode = 'DK';
$agreementCountry = 'DK';
$city = urlencode($dawaSanitizedAddress->resultater[0]->adresse->postnrnavn);
$postalCode = urlencode($dawaSanitizedAddress->resultater[0]->adresse->postnr);
$streetName = urlencode($dawaSanitizedAddress->resultater[0]->adresse->adresseringsvejnavn);
$streetNumber = urlencode($dawaSanitizedAddress->resultater[0]->adresse->husnr);
$numberOfServicePoints = urlencode(10);



$apikey = file_get_contents('../../secret/postnord_apikey');
$url = "https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&countryCode=$countryCode&agreementCountry=$agreementCountry&city=$city&postalCode=$postalCode&streetName=$streetName&streetNumber=$streetNumber&numberOfServicePoints=$numberOfServicePoints&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public";

// Returnere et json objekt med lokale service points
$json = shell_exec("curl --location --request GET '$url' 2> /dev/null"); // navigere stderr 2> /dev/null

echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
// --- Hent service points --- //