<?php
namespace vezit\_services\login_service;

require __DIR__.'/../../../global-requirements.php';

use vezit\_dto\login\resquest as Request;

$username = 'test@steengede.com';
$password = 'Passw0rd';



// php -f _tests/services/login_service/Login_Service_validate_user_credentials.php
$login_request = new Request\Login_Request();
$login_request->username = $username;
$login_request->password = $password;



$login_service = new Login_Service();
$result = $login_service->validate_user_credentials($login_request);

echo json_encode($result, JSON_PRETTY_PRINT);
