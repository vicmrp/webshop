<?php
namespace vezit\_repositories\active_directory;

require __DIR__.'/../../../global-requirements.php';
use vezit\_dto\login\resquest as Login_Request;
use vezit\_dto\tspa\request as Tspa_Request;
use vezit\_dto\tspa\response as Tspa_Response;


$active_directory = new Active_Directory();

// php -f _tests/repositories/active_directory/Active_Directory.php

$login_request = new Login_Request\Login_Request();
$login_request->username = 'test@steengede.com';
$login_request->password = 'Passw0rd';
$login_request->groupmember = 'byg-it-afd';

$result = $active_directory->credentials_verify($login_request, $unit_test=true);

var_dump($result);
