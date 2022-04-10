<?php
namespace vezit\classes\session;

// require_once __DIR__.'/../../global-requirements.php';

interface ISession {

  public function new_session_id() : string;

  public function set_session_id(string $session_id) : void;

  public function get_session_id() : string;

}