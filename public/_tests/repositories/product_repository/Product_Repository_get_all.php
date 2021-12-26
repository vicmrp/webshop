<?php

namespace vezit\_repositories\product_repository;

require __DIR__.'/../../../global-requirements.php';

use vezit\_entities\user as Entity;
use vezit\_classes\error as Error;


// php -f _tests/repositories/product_repository/Product_Repository_get_all.php
$user_repository = new Product_Repository();
$result = $user_repository->get_all();
var_dump($result);
