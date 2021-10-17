<?php
namespace vezit\interfaces;

require __DIR__.'/../global-requirements.php';

interface ISession {

  public function create(int $x);

  public function get_by_id($order_id);

  public function update_by_id($order_id);

}