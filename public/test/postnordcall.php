<?php
// ----- global ----- //
require_once __DIR__.'/../global-requirements.php'; // _from_top_folder().
use vezit\classes\api\postnord as Postnord;
use vezit\classes\api\dawa as Dawa;



$sanitized_address = Dawa\Dawa::call_get_sanitized_address('Øresundshøj 3a','2920');


echo json_encode(Postnord\Postnord::call_get_servicepoints($sanitized_address),JSON_PRETTY_PRINT);
