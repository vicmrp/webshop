<?php

// ----- global ----- //
require __DIR__.'/../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\api as A;

// $x = new A\Api();

// var_dump($x);

// $x

echo A\Api::quickpay->get_helloworld();