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
    $access_granted = password_verify($login_request->password, $user_entity->hash);

    if ($access_granted) $_SESSION['session_var_active'] = true;  

    $login_response = new Login_Response\Login_Response();
    $login_response->username =  $login_request->username;
    $login_response->access_granted = $access_granted ? true : false;
    $login_response->session_var_active = $_SESSION['session_var_active'];
    
    return $login_response;
  }

  public function logout() : Login_Response\Logout_Response {
    $logout_response = new Login_Response\Logout_Response();
    if (isset($_SESSION['session_var_active']))
      unset($_SESSION['session_var_active']);
    
    return $logout_response;
  }
}
