<?php
$apikey = '9b35d623bebf67be253e7b17fa658e79';

$countryCode = 'DK';
$agreementCountry ='DK';
$city = 'vinkelvej';
$postalCode = '3210';
$streetName = 'Lundevej';
$streetNumber = '15';
$numberOfServicePoints = 1;


## Denne query returnere et json objekt med lokale service points
# navigere stderr 2> /dev/null
$json = shell_exec("curl --location --request GET 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&countryCode=$countryCode&agreementCountry=$agreementCountry&city=$city&postalCode=$postalCode&streetName=$streetName&streetNumber=$streetNumber&numberOfServicePoints=$numberOfServicePoints&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public' 2> /dev/null");

echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
