<?php

// php -f tests/services/session_service/Session_Service_get_session.php

namespace vezit\services\session_service;
require __DIR__.'/../../../global-requirements.php';
$session_service = new Session_Service();

// var_dump($session_service->get_session());
echo json_encode($session_service->get_session(), JSON_PRETTY_PRINT);
