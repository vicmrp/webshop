<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().'/

// Starter sessionen
if (session_status() === PHP_SESSION_NONE) {
  session_start();  
}


$session = $_SESSION["session"];



// Forstil dig at du udfylder kontakt og leverings informationer

// Customer
$fullname = "Julian Christ";
// Contact
$phone = "12457845";
$email = "just-julian@hotmail.com";
// Address
$street = "Ryethøjvej 1";
$postal_code = "3500";
$city = "Værløse";
// Company
$cvr_number = "";
$company_name = "";

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
