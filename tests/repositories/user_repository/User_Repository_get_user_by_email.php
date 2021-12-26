<?php

namespace vezit\repositories\user_repository;

require __DIR__.'/../../../global-requirements.php';

use vezit\entities\user as Entity;
use vezit\classes\error as Error;


// php -f _tests/repositories/user_repository/User_Repository_get_user_by_email.php
$user_repository = new User_Repository();
$result = $user_repository->get_user_by_email('test@steengede.com');
var_dump($result);
