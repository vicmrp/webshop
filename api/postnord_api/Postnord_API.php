<?php namespace vezit\api\postnord_api;

require __DIR__.'/../../global-requirements.php';

use vezit\dto\Postnord_Service_Point_Response;
use vezit\models\Sanitized_Address;

class Postnord_API
{
    // --- Hent service points --- //
    // Documentation
    // https://guides.developer.postnord.com/
    public function call_get_servicepoints(Sanitized_Address $sanitized_address, int $max_return_of_service_points = 10) : object {

        // paramentere
        $country_code             = 'DK';
        $agreement_country        = 'DK';
        $city                     = urlencode($sanitized_address->city);
        $postal_code              = urlencode($sanitized_address->postal_code);
        $street_name              = urlencode($sanitized_address->street_name);
        $street_number            = urlencode($sanitized_address->street_number);
        $number_of_service_points = urlencode($max_return_of_service_points);
        global $g_postnord_apikey;



        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api2.postnord.com/rest/businesslocation/v5/servicepoints/nearest/byaddress?apikey=$g_postnord_apikey&returnType=json&countryCode=$country_code&agreementCountry=$agreement_country&city=$city&postalCode=$postal_code&streetName=$street_name&streetNumber=$street_number&numberOfServicePoints=$number_of_service_points&srId=EPSG:4326&context=optionalservicepoint&responseFilter=public",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(),
        ));

        $postnord_json_response = curl_exec($curl);

        curl_close($curl);


        $postnord_response = json_decode($postnord_json_response);

        return $postnord_response;
    }



    public function call_find_service_point_by_id(int $service_point_id) : object {

        $curl = curl_init();
        global $g_postnord_apikey;

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api2.postnord.com/rest/businesslocation/v5/servicepoints/ids?apikey=$g_postnord_apikey&returnType=json&countryCode=DK&ids=$service_point_id&responseFilter=public",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $service_points = json_decode($response, false);

        return $service_points;

    }
}
