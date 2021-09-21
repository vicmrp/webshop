<?php

function datavask($user_address_input, $user_postal_code_input) {
  // --- bruger/maskin input --- //
  // Variable input fra brugeren - baseret pa av-cables.dk kundeoplysningsformular
  // $user_address_input = null; // Vejnavn + husnummer - Vinkelvej 12d, 3tv - Øresundshøj 3a, 2920 - Lundevej 15, 3210 Vejby
  // $user_postal_code_input = 2800; // Postnummer - 2800
  // --- bruger/maskin input --- //




  // --- dawa vask addresse --- //
  $betegnelse = urlencode("$user_address_input" . ", " . "$user_postal_code_input");
  $dawa_response = shell_exec("curl --location --request GET 'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=$betegnelse' 2> /dev/null");
  $dawa_sanitized_address = json_decode($dawa_response);
  // echo json_encode(json_decode($dawa_response), JSON_PRETTY_PRINT);
  // --- dawa vask addresse --- //

  // retunere json i flot format 
  return json_encode(json_decode($dawa_response), JSON_PRETTY_PRINT);
}

