<?php
namespace vezit\_repositories\user;

require __DIR__.'/../../global-requirements.php';

use vezit\_entities\user as Entity;

interface IUser {

  public function get_user_by_id(int $id) : object;
  public function get_user_by_email(string $email) : Entity\User;
  public function get_user_by_role(string $email) : object;


  // public function insert(object $product) : void;
  // public function update(string $id, object $product) : void;
  // public function delete(object $product) : void;
}