<?php
require_once __DIR__.'/api/dawa/datavask.php';
require_once __DIR__.'/api/postnord/service-points.php';
session_start();


$_SESSION["customer"] = new ;

// Flow eksempel

// Opretter session objekt som følger kunden


// Det her script repræsentere at en kunde har indtastet 1. kundeoplysninger, 2. Fragt. og betaling. 3. Godkendelse af ordre


// --- Skal forstille klienten --- //

  // --- input af kundeoplysninger --- //
  // Kunden har indtast sine kundeoplysninger
  // fulde navn, mobilnummer, email, addresse og postnummer. (by hentes via dawa igennem postnummeret)




  $customer_info = '
{
  "fullName": "Victor Reipur",
  "phone": "26129604",
  "email": "victor.reipur@gmail.com",
  "customerAddress": {
      "streetNameAndStreetNumber": "Vinkelvej 12d 3tv",
      "postalCode": "2800",
      "city": ""
  },
  "deliveryAddress" : null,
  "company": {
      "cvrNumber": "",
      "companyName": ""
  }
}';


    $customer = json_decode($customer_info);
    // --- dawa henter by baseret postnummer --- //
    // dawa skal oprettes som en funktion
    // $user_address_input = null;
    $user_address_input = $customer->customerAddress->streetNameAndStreetNumber;
    $user_postal_code_input = $customer->customerAddress->postalCode;

    $dawa_sanitized_address_obj = json_decode(datavask($user_address_input, $user_postal_code_input));

    $customer->customerAddress->city = $dawa_sanitized_address_obj->resultater[0]->adresse->postnrnavn;
    
    $streetName = $dawa_sanitized_address_obj->resultater[0]->adresse->vejnavn;
    $houseNumber = $dawa_sanitized_address_obj->resultater[0]->adresse->husnr;
    $floor = $dawa_sanitized_address_obj->resultater[0]->adresse->etage;
    $door = $dawa_sanitized_address_obj->resultater[0]->adresse->dør;
    $postal_code = $dawa_sanitized_address_obj->resultater[0]->adresse->postnr;

    $address = "$streetName $houseNumber, $floor$door";
    $postal_code = $postal_code;
    // --- dawa henter by baseret postnummer --- //
  // --- input af kundeoplysninger --- // 

echo "$address, $postal_code";

  // --- Oprettelse input af fragt --- //
    // Her vælger kunden stedet hvor pakken skal sendes til. - han vælger et service point
    // Det kan være et service point eller kundes egen addresse.

    echo json_encode($customer, JSON_PRETTY_PRINT);
    echo "\n\n\n\n\n\n";

    $delivery_obj = json_decode(postnord_getServicePoints($address, $postal_code, 1));
    echo json_encode($delivery_obj->servicePointInformationResponse->servicePoints[0]->deliveryAddress, JSON_PRETTY_PRINT);
    echo "\n\n\n\n\n\n";
    $customer->deliveryAddress = $delivery_obj->servicePointInformationResponse->servicePoints[0]->deliveryAddress;
    echo json_encode($customer, JSON_PRETTY_PRINT);
    // Kunde vælger service point, og det gemmes i order objektet.
    
    // var_dump($customer);
  // --- Oprettelse input af fragt --- //
// --- Skal forstille klienten --- //









// Skal forstille serveren --- //
  // --- input af fragt --- //

  // --- input af fragt --- //
// Skal forstille serveren --- //
