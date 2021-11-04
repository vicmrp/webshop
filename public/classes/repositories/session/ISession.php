<?php

namespace vezit\classes\repositories\session;

interface ISession {
  public function find(string $session_id) : object;
  public function insert(object $session) : void;
  public function update(string $session_id, object $payment_status) : void;
  public function delete(object $entity) : void;
}
