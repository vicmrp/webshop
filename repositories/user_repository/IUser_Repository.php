<?php
namespace vezit\repositories\user_repository;

require __DIR__.'/../../global-requirements.php';

use vezit\entities\user\User;

interface IUser_Repository {

  public function get_user_by_id(int $id) : User;
  public function get_user_by_email(string $email) : User;
  public function get_user_by_role(string $email) : object;

}