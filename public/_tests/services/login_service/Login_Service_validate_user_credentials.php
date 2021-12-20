<?php
namespace vezit\_services\login_service;

require __DIR__.'/../../../global-requirements.php';

use vezit\_dto\login\resquest as Request;

// php -f _tests/services/login_service/Login_Service_validate_user_credentials.php
$login_request = new Request\Login_Request();
$login_request->username = 'test@steengede.com';
$login_request->password = 'Passw0rd';
$login_request->groupmember = 'byg-it-afd';

$login_service = new Login_Service();
$result = $login_service->validate_user_credentials($login_request, true);

var_dump($result);
