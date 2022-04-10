<?php

namespace vezit\repositories\product_repository;

require_once __DIR__.'/../../../global-requirements.php';



// php -f tests/repositories/product_repository/Product_Repository_get_all.php
$product_repository = new Product_Repository();
$result = $product_repository->find(1);
var_dump($result);
