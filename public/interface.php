<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php'; // _from_top_folder().

use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session as Session;
use vezit\classes\repositories\session as R_Session;

// Starts session
if (session_status() === PHP_SESSION_NONE) {
  session_start();  
}

function find_session($session_id) : string {
  $r_session = new R_Session\Session;
  $session_json = json_encode($r_session->find($session_id), JSON_PRETTY_PRINT);
  return $session_json;
}

function create_session() : string {
  $session = new Session\Session();
  $r_session = new R_Session\Session;
  $r_session->insert($session);
  $session_json = json_encode($session, JSON_PRETTY_PRINT);
  return $session_json;
}

function add_order_item($product_id, $quantity) : string {

}

$request = isset($_GET["request"]) ? $_GET['request'] : 'No message specified';
$parameters = json_decode(file_get_contents("php://input"));


switch ($request) {
  case 'find_session':
    $result = find_session($parameters->session_id);
    break;
  case 'create_session':
    $result = create_session();
    break;
  case 'add_order_item':
    $result = add_order_item($parameters->product_id, $parameters->quantity);
    break;
  default:
    error_log("unkown request");
    break;
}

echo $result;
