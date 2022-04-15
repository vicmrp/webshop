<?php
namespace vezit\classes\api\postnord;
use vezit\dto\postnord\request as Request;
use vezit\dto\postnord\response as Response;
require __DIR__.'/../../../global-requirements.php';


class Postnord {

  // --- Hent service points --- //
  // Documentation 
  // https://guides.developer.postnord.com/
  public static function call_get_servicepoints(Request\Postnord_Service_Points_Request $postnord_service_points_request, int $max_return_of_service_points = 10) : Response\Postnord_Service_Points_Response {
    
    // paramentere
    $country_code             = 'DK';
    $agreement_country        = 'DK';
    $city                     = urlencode($postnord_service_points_request->sanitized_address_response->city);
    $postal_code              = urlencode($postnord_service_points_request->sanitized_address_response->postal_code);
    $street_name              = urlencode($postnord_service_points_request->sanitized_address_response->street_name);
    $street_number            = urlencode($postnord_service_points_request->sanitized_address_response->street_number);
    $number_of_service_points = urlencode($max_return_of_service_points);
    global $g_postnord_apikey;
    $uri = 'https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress';
    $url = "$uri?apikey=$g_postnord_apikey&returnType=json&countryCode=$country_code&agreementCountry=$agreement_country&city=$city&postalCode=$postal_code&streetName=$street_name&streetNumber=$street_number&numberOfServicePoints=$number_of_service_points&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public";
    $postnord_json_response = shell_exec("curl --location --request GET '$url' 2> /dev/null"); // navigere stderr 2> /dev/null
    $postnord_response = json_decode($postnord_json_response);


    $postnord_service_points_response = new Response\Postnord_Service_Points_Response();
    

    $service_points = $postnord_response->servicePointInformationResponse->servicePoints;

    for ($i=0; $i < count($service_points); $i++) {
      $postnord_service_point_response = new Response\Postnord_Service_Point_Response();
      $postnord_service_point_response->index = $i;
      $postnord_service_point_response->street_name    = $postnord_response->servicePointInformationResponse->servicePoints[$i]->visitingAddress->streetName;
      $postnord_service_point_response->street_number  = $postnord_response->servicePointInformationResponse->servicePoints[$i]->visitingAddress->streetNumber;
      $postnord_service_point_response->postal_code    = $postnord_response->servicePointInformationResponse->servicePoints[$i]->visitingAddress->postalCode;
      $postnord_service_point_response->city           = $postnord_response->servicePointInformationResponse->servicePoints[$i]->visitingAddress->city;
      array_push($postnord_service_points_response->service_points, $postnord_service_point_response);
    }
    
    return $postnord_service_points_response;
    
  }
}