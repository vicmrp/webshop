<?php

// php -f tests/services/product_service/Product_Service_get_by_id.php

namespace vezit\services\product_service;

require __DIR__.'/../../../global-requirements.php';

$product_service = new Product_Service();
var_dump($product_service->get_by_id(1));