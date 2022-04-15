<?php // php -f tests_none_unit/repositories/user_repository/User_Repository_get_user_by_email.php
namespace vezit\repositories\user_repository;

require_once __DIR__.'/../../../global-requirements.php';

use vezit\classes\mysqli\Mysqli;

$user_repository = new User_Repository(new Mysqli());
$result = $user_repository->get_user_by_email('test@steengede.com');
dd($result);
