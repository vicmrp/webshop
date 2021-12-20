<?php
namespace vezit\_services\login_service;

require __DIR__.'/../../global-requirements.php';

use vezit\_dto\login\resquest as Login_Request;
use vezit\_dto\login\response as Login_Response;
use vezit\_repositories\active_directory as Repository;


class Login_Service implements ILogin_Service {
  

  public function validate_user_credentials(Login_Request\Login_Request $login_request, $unit_test=false) : Login_Response\Login_Response {
    $login_response = new Login_Response\Login_Response();
    $active_directory = new Repository\Active_Directory();

    $login_response->username =  $login_request->username;
    $login_response->groupmember = $login_request->groupmember;
    $login_response->varified = ($unit_test) ? true : (bool)$active_directory->credentials_verified($login_request);
    return $login_response;
  }

  public function set_login_session_response($login_response) : bool {
    $_SESSION['login_session_response'] = json_encode($login_response);
    

    // $_SESSION['login_session_response'] = new Login_Response\Login_Response();
    // $_SESSION['login_session_response']->username = $login_response->username;
    // $_SESSION['login_session_response']->groupmember = $login_response->groupmemberM;
    // $_SESSION['login_session_response']->varified = $login_response->varified;
    // $_SESSION['login_session_response']->login_session_response_isset = isset($_SESSION['login_session_response']);
    
    return isset($_SESSION['login_session_response']);
  }

  public function get_login_session_response() {
    return ($_SESSION['login_session_response']) ? json_decode($_SESSION['login_session_response']) : json_decode('{"test":"HelloWorld"}');
  }
}
