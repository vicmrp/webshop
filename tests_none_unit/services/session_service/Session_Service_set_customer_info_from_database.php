<?php

// php -f tests/services/session_service/Session_Service_set_customer.php

namespace vezit\services\session_service;
require_once __DIR__.'/../../../global-requirements.php';
$session_service = new Session_Service();


$customer_info_from_database =
array(
  'fullname'=>'Victor Reipur',
  'phone'=>'26129604',
  'email'=>'victor.reipur@gmail.com',
  'street'=>'vinkelvej 12d, 3tv',
  'postal_code'=>'2800',
  'city'=>'Lyngby',
  'cvr_number'=>null,
  'company_name'=>null
);


// var_dump($session_service->get_session());
echo json_encode($session_service->set_customer_info_from_database($customer_info), JSON_PRETTY_PRINT);
