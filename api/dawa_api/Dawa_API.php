<?php namespace vezit\api\dawa_api;

use vezit\models\sanitized_address\Sanitized_Address;

require __DIR__.'/../../global-requirements.php';

class Dawa_API {

    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance() {
        return null === self::$_instance ? new Dawa_API : self::$_instance;
    }


    private function __construct()
    {self::$_times_instantiated++;}


    // Renser en addresse og retunere et json objekt med en ren addresse
    //
    // INPUT
    // $street_name_and_house_number = 'Vejnavn + husnummer' | 'Vinkelvej 12d, 3tv' | 'Øresundshøj 3a' | 'Lundevej 15'
    // $postal_code = 'postnummer' | 2800 | 2920 | 3210
    // RETURNS
    // renset addresse objekt
    //
    // Dokumentation
    // https://dawadocs.dataforsyningen.dk/dok/guide/datavask
    public function call_get_sanitized_address(string $street_name_and_house_number, string $postal_code) : Sanitized_Address
    {
        // $betegnelse = urlencode("$street_name_and_house_number" . ", " . "$postal_code");
        $betegnelse = urlencode("$street_name_and_house_number, $postal_code");



        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(),
        ));

        $dawa_json_response = curl_exec($curl);

        curl_close($curl);


        $dawa_response = json_decode($dawa_json_response);

        $sanitized_address_response = new Sanitized_Address();
        $sanitized_address_response->city =             $dawa_response->resultater[0]->adresse->postnrnavn;
        $sanitized_address_response->postal_code =      $dawa_response->resultater[0]->adresse->postnr;
        $sanitized_address_response->street_name =      $dawa_response->resultater[0]->adresse->adresseringsvejnavn;
        $sanitized_address_response->street_number =    $dawa_response->resultater[0]->adresse->husnr;

        return $sanitized_address_response;
    }
}