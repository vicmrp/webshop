<?php
require_once __DIR__.'/api/dawa/datavask.php';
require_once __DIR__.'/api/postnord/service-points.php';

// Det her script repræsentere at en kunde har indtastet 1. kundeoplysninger, 2. Fragt. og betaling. 3. Godkendelse af ordre


// --- Skal forstille klienten --- //

  // --- input af kundeoplysninger --- //
  // Kunden har indtast sine kundeoplysninger
  // fulde navn, mobilnummer, email, addresse og postnummer. (by hentes via dawa igennem postnummeret)
  $customer = json_decode(file_get_contents("flow_example/av-cables-kundeoplysninger.json"));
    // --- dawa henter by baseret postnummer --- //
    // dawa skal oprettes som en funktion
    $user_address_input = null;
    $user_postal_code_input = $customer->postalCode;
    $dawa_sanitized_address_obj = json_decode(datavask($user_address_input, $user_postal_code_input));
    // $betegnelse = urlencode("$user_address_input" . ", " . "$user_postal_code_input");
    // $dawa_response = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");
    // $dawa_sanitized_address = json_decode($dawa_response);
    $customer->city = $dawa_sanitized_address_obj->resultater[0]->adresse->postnrnavn;
    echo $customer->city;

    
    // --- dawa henter by baseret postnummer --- //
  // --- input af kundeoplysninger --- // 



  // --- Oprettelse input af fragt --- //
    // Her vælger kunden stedet hvor pakken skal sendes til. - han vælger et service point
    // Det kan være et service point eller kundes egen addresse.

    // Kunde vælger service point, og det gemmes i order objektet.
    

  // --- Oprettelse input af fragt --- //
// --- Skal forstille klienten --- //

// Skal forstille serveren --- //
  // --- input af fragt --- //

  // --- input af fragt --- //
// Skal forstille serveren --- //
