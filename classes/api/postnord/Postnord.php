<?php
namespace vezit\classes\api\postnord;
require_once __DIR__.'/../../../global-requirements.php';


class Postnord {

  // --- Hent service points --- //
  // Documentation 
  // https://guides.developer.postnord.com/
  public static function call_get_servicepoints(object $sanitized_address, int $max_return_of_service_points = 10) {
    
    // paramentre
    $country_code             = 'DK';
    $agreement_country        = 'DK';
    $city                     = urlencode($sanitized_address->resultater[0]->adresse->postnrnavn);
    $postal_code              = urlencode($sanitized_address->resultater[0]->adresse->postnr);
    $street_name              = urlencode($sanitized_address->resultater[0]->adresse->adresseringsvejnavn);
    $street_number            = urlencode($sanitized_address->resultater[0]->adresse->husnr);
    $number_of_service_points = urlencode($max_return_of_service_points);
    global $g_postnord_apikey;
    $uri = 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress';
    $url = "$uri?apikey=$g_postnord_apikey&returnType=json&countryCode=$country_code&agreementCountry=$agreement_country&city=$city&postalCode=$postal_code&streetName=$street_name&streetNumber=$street_number&numberOfServicePoints=$number_of_service_points&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public";
    $postnord_json_response = shell_exec("curl --location --request GET '$url' 2> /dev/null"); // navigere stderr 2> /dev/null
    return json_decode($postnord_json_response);
    
  }
}