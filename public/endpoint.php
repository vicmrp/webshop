<?php
// ----- global ----- //
require_once __DIR__.'/global-requirements.php';

use vezit\classes\api\endpoint as E;
use vezit\classes\login as Login;
use vezit\classes\tspa as Tspa;
use vezit\classes\error as Error;
session_start();

$required_get_parameters = array('functioncall');
$endpoint = new E\Endpoint();
$endpoint->set_expected_get_parameters($required_get_parameters);
$endpoint->set_body(file_get_contents("php://input"));


switch ($endpoint->get_parameter->functioncall) {

  case 'get_powershell_script':
    $required_get_parameters = array('computername');
    $endpoint->set_expected_get_parameters($required_get_parameters);
    $tspa = new Tspa\Tspa();
    echo $tspa->get_powershell_script($endpoint->get_parameter->computername);
    break;

  case 'set_validation_result':
    $endpoint->set_expected_body_properties(array('username', 'identity'));
    $login = new Login\Login();
    $login->set_username($endpoint->body->username);
    $login->set_identity($endpoint->body->identity);
    $login->set_groupmember('byg-it-afd');
    $login->set_validation_result();
    echo json_encode($login->set_validation_result(), JSON_PRETTY_PRINT);
    break;

  case 'get_login_status':
    $login = new Login\Login();
    echo json_encode($login->get_login_status());
    break;

  case 'set_destroy_login_session':
    $login = new Login\Login();
    echo json_encode($login->set_destroy_login_session());    
    break;

  default:
    $error_message = "interface Unknown functioncall: " . $endpoint->get_parameter->functioncall;
    new Error\Error(__FILE__, $error_message, $fatal_error=true);
    break;
}
