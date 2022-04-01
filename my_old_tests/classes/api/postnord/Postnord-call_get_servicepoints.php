<?php

namespace vezit\classes\api\postnord;
use vezit\classes\api\dawa as Dawa;
use vezit\dto\postnord\request as Request;
require __DIR__.'/../../../../global-requirements.php';

# php -f tests/classes/api/postnord/Postnord-call_get_servicepoints.php
$sanitized_address_response = Dawa\Dawa::call_get_sanitized_address('Vinkelvej 12D, 3tv', "2800");

$postnord_service_points_request = new Request\Postnord_Service_Points_Request();
$postnord_service_points_request->sanitized_address_response = $sanitized_address_response;

$postnord_service_points_response = Postnord::call_get_servicepoints($postnord_service_points_request, 2);

var_dump($postnord_service_points_response);
