<?php
namespace vezit\classes\session;

// require __DIR__.'/../../global-requirements.php';

interface ISession {

  public static function new_session_id() : string;

  public function set_session_id(string $session_id) : void;

  public function get_session_id() : string;

}