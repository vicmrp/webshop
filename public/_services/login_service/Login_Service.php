<?php
namespace vezit\_services\login_service;

require __DIR__.'/../../global-requirements.php';

use vezit\_dto\login\resquest as Login_Request;
use vezit\_dto\login\response as Login_Response;
use vezit\_repositories\user_repository as User_Repository;

class Login_Service implements ILogin_Service {
  

  public function validate_user_credentials(Login_Request\Login_Request $login_request) : Login_Response\Login_Response {

    $user_repository = new User_Repository\User_Repository();
    
    $user_entity = $user_repository->get_user_by_email($login_request->username);

    $login_response = new Login_Response\Login_Response();
    $login_response->username =  $login_request->username;
    $login_response->access_granted = password_verify($login_request->password, $user_entity->hash) ? true : false;    
    return $login_response;

  }

  public function set_login_session_response($login_response) : bool {
    $_SESSION['login_session_response'] = json_encode($login_response);
    
    
    return isset($_SESSION['login_session_response']);
  }

  public function get_login_session_response() {
    return ($_SESSION['login_session_response']) ? json_decode($_SESSION['login_session_response']) : json_decode('{"test":"HelloWorld"}');
  }
}
