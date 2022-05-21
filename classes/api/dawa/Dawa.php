<?php


namespace vezit\classes\api\dawa;
use vezit\dto\Sanitized_Address;

require __DIR__.'/../../../global-requirements.php';

class Dawa {

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
    public static function call_get_sanitized_address(string $street_name_and_house_number, string $postal_code) : Sanitized_Address
    {
        // $betegnelse = urlencode("$street_name_and_house_number" . ", " . "$postal_code");
        $betegnelse = urlencode("$street_name_and_house_number, $postal_code");
        $dawa_json_response = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");

        $dawa_response = json_decode($dawa_json_response);

        $sanitized_address_response = new Sanitized_Address();
        $sanitized_address_response->city =             $dawa_response->resultater[0]->adresse->postnrnavn;
        $sanitized_address_response->postal_code =      $dawa_response->resultater[0]->adresse->postnr;
        $sanitized_address_response->street_name =      $dawa_response->resultater[0]->adresse->adresseringsvejnavn;
        $sanitized_address_response->street_number =    $dawa_response->resultater[0]->adresse->husnr;

        return $sanitized_address_response;
    }
}