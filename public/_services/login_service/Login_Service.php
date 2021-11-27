<?php
namespace vezit\_services\login_service;

require __DIR__.'/../../global-requirements.php';

use vezit\_repositories\user as User;
use vezit\_dto\user\resquest as Request;
use vezit\_dto\user\response as Response;
use vezit\_classes\error as Error;


class Login_Service implements ILogin_Service {

  public function validate_user_credentials(Request\Login_Request $login_request) : Response\Login_Response {

    $user = new User\User();
    
    $result = $user->get_user_by_email($login_request->email);
    $password_varify = password_verify($login_request->password, $result->password);
    $login_response = new Response\Login_Response();
    $login_response->email = $result->email;

    $login_response->user_credentials_is_valid = $password_varify ? true : false;


    $login_response->php_session_is_active = (session_status() === 2) ? true : false;


    return $login_response;
  }

}


// // php -f _services/login_service/Login_Service.php
// $login_request = new Request\Login_Request();
// $login_request->email = 'test@steengede.com';
// $login_request->password = 'Passw0rd';
// $login_service = new Login_Service();
// $result = $login_service->validate_user_credentials($login_request);
// var_dump($result);