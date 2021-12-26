<?php

namespace vezit\repositories\product_repository;

require __DIR__.'/../../../global-requirements.php';

use vezit\entities\user as Entity;
use vezit\classes\error as Error;


// php -f _tests/repositories/product_repository/Product_Repository_get_all.php
$user_repository = new Product_Repository();
$result = $user_repository->get_all();
var_dump($result);
