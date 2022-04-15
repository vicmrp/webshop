<?php

// php -f tests/services/session_service/Session_Service_add_order_item.php

namespace vezit\services\session_service;
require_once __DIR__.'/../../../global-requirements.php';
$session_service = new Session_Service();

$product_id = 1;
$quantity = 2;





// var_dump($session_service->get_session());

echo json_encode($session_service->add_order_item($product_id, $quantity), JSON_PRETTY_PRINT);


