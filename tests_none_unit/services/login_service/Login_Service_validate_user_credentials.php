<?php
namespace vezit\services\login_service;

require_once __DIR__.'/../../../global-requirements.php';

use vezit\dto\login\request\Login_Request;
use vezit\repositories\user_repository\User_Repository;

$username = 'test@steengede.com';
$password = 'Passw0rd';



// php -f non_unit_test/services/login_service/Login_Service_validate_user_credentials.php
$login_request = new Login_Request();
$login_request->username = $username;
$login_request->password = $password;



$login_service = new Login_Service(new User_Repository());
$result = $login_service->validate_user_credentials($login_request);

dd($result);
