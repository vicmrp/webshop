<?php
namespace vezit\classes\session;

// require __DIR__.'/../../global-requirements.php';

interface ISession {

  public function create(int $x); // Creater ligesa snart en bruger tilgar siden.

  public function get_session_by_id($order_id); // Henter data om tidligere session baseret pa session id

  public function update_by_id($order_id);

}