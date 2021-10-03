<?php
// ----- global ----- //
require_once __DIR__.'/../global-requirements.php'; // _from_top_folder().
use vezit\classes\api\dawa as Dawa;

echo json_encode(Dawa\Dawa::get_sanitized_address('Øresundshøj 3a','2920'), JSON_PRETTY_PRINT);
