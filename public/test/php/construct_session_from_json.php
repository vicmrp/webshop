<?php 
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().

use vezit\classes\session as Session;

$session = new Session\Session();
use vezit\classes\repositories\session as R_Session;

function find_session($session_id) : object {
  $r_session = new R_Session\Session;
  return (object)$r_session->find($session_id);
}

$session->construct_session_from_repository(find_session("1338498"));

echo json_encode($session, JSON_PRETTY_PRINT);