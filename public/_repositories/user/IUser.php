<?php
namespace vezit\classes\repositories\user;

interface IUser {

  public function get_by_id(int $id) : object;
  public function get_by_email(string $email) : object;
  public function get_by_role(string $email) : object;


  // public function insert(object $product) : void;
  // public function update(string $id, object $product) : void;
  // public function delete(object $product) : void;
}