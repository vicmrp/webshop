<?php
$apikey = '9b35d623bebf67be253e7b17fa658e79';

$countryCode = 'DK';
$agreementCountry ='DK';
$city = '';
$postalCode = '3210';
$streetName = 'Lundevej';
$streetNumber = '15';
$numberOfServicePoints = 1;


## Denne query returnere et json objekt med lokale service points
$json = shell_exec("curl --location --request GET 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&countryCode=$countryCode&agreementCountry=$agreementCountry&city=$city&postalCode=$postalCode&streetName=$streetName&streetNumber=$streetNumber&numberOfServicePoints=$numberOfServicePoints&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public'");
// $json = shell_exec("curl --location --request GET 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=9b35d623bebf67be253e7b17fa658e79&returnType=json&countryCode=DK&agreementCountry=DK&city=Lyngby&postalCode=2800&streetName=Vinkelvej&streetNumber=12D&numberOfServicePoints=10&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public'");
// https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=9b35d623bebf67be253e7b17fa658e79&returnType=json&countryCode=DK&agreementCountry=DK&city=Lyngby&postalCode=2800&streetName=Vinkelvej&streetNumber=12D&numberOfServicePoints=10&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public&callback=jsonp


// $json = shell_exec(`curl --location -g --request GET 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$apikey&returnType=json&$countryCode=SE&agreementCountry=$agreementCountry&city=$city&postalCode=$postalCode&streetName=$streetName%2014&numberOfServicePoints=10&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public'`);

// curl --location -g --request GET https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=9b35d623bebf67be253e7b17fa658e79&returnType=json&countryCode=SE&agreementCountry=SE&city=Gislaved&postalCode=33234&streetName=Holmengatan&streetNumber=14&numberOfServicePoints=10&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public&typeId=24,25,54&callback=jsonp
// https://api2.postnord.com/rest/businesslocation/v5/servicepoints/bypostalcode?apikey={{apikey}}&returnType=json&countryCode=SE&postalCode=33234&context=optionalservicepoint&responseFilter=public&typeId=25&callback=jsonp

// echo $json;

$obj = json_decode($json);

$pretty_json = json_encode($obj, JSON_PRETTY_PRINT);

echo $pretty_json;

// var_dump($obj);

// Returnere DK
// echo $obj->servicePointInformationResponse->customerSupports[0]->country;


