<?php

namespace vezit\services\login_service;
require __DIR__ . '/../../global-requirements.php';


use vezit\dto\login\request\Login_Request;
use vezit\dto\login\response\Login_Response;
use vezit\dto\login\response\Is_User_Logged_In_Response;
use vezit\repositories\user_repository\User_Repository;
use vezit\classes\mysqli\Mysqli;

class Login_Service implements ILogin_Service
{

    public function __construct(private User_Repository $_user_repository = new User_Repository)
    {
    }


    public function validate_user_credentials(Login_Request $login_request): Login_Response
    {

        $user_entity = $this->_user_repository->get_user_by_email($login_request->username);
        $access_granted = (bool)password_verify($login_request->password, $user_entity->hash);

        $_SESSION['session_var_active'] = $access_granted ? true : false;

        $login_response = new Login_Response();
        $login_response->username =  $login_request->username;
        $login_response->access_granted = $access_granted ? true : false;
        $login_response->session_var_active = $_SESSION['session_var_active'];

        return $login_response;
    }

    public function check_if_user_is_logged_in(): Is_User_Logged_In_Response
    {

        $is_user_logged_in_response = new Is_User_Logged_In_Response();

        $is_user_logged_in_response->user_is_logged_in = isset($_SESSION['session_var_active']) ? true : false;

        return $is_user_logged_in_response;
    }

    public function logout(): Is_User_Logged_In_Response
    {
        $logout_response = new Is_User_Logged_In_Response();
        if (isset($_SESSION['session_var_active']))
            unset($_SESSION['session_var_active']);

        $logout_response->user_is_logged_in = false;

        return $logout_response;
    }
}
