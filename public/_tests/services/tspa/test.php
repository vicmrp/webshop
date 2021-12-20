<?php

namespace vezit\_services\tspa;

require __DIR__.'/../../../global-requirements.php';

use vezit\_dto\tspa\request as Tspa_Request;


// test
// php -f _tests/services/tspa/test.php
$powershell_script_request = new Tspa_Request\Powershell_Script_Request();
$powershell_script_request->computername = 'byg-a101-vicre';

$tspa = new Tspa();
$response = $tspa->get_powershell_script($powershell_script_request);

echo json_encode($response, JSON_PRETTY_PRINT);