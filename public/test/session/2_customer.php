<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().'/

// use vezit\classes\session as Session;

session_start();
$session = $_SESSION["session"];



// Forstil dig at du udfylder kontakt og leverings informationer

// Customer
$fullname = "Victor Reipur";
// Contact
$phone = "26129604";
$email = "Victor.reipur@gmail.com";
// Address
$street = "Vinkelvej 12d, 3tv";
$postal_code = "2800";
$city = "KGS. LYNGBY";
// Company
$cvr_number = "10007933";
$company_name = "SGUPS v/Steen Gede";

// Contact
$session->customer->set_fullname($fullname);
$session->customer->contact->set_phone($phone);
$session->customer->contact->set_email($email);
$session->customer->address->set_street($street);
$session->customer->address->set_postal_code($postal_code);
$session->customer->address->set_city($city);
$session->customer->company->set_cvr_number($cvr_number);
$session->customer->company->set_company_name($company_name);

echo "<pre>" . json_encode($session, JSON_PRETTY_PRINT) . "</pre>";


// Vi gar nu videre til valg af leveringslokation. Her skal du bruge API op imod postnord
$_SESSION["session"] = $session;
