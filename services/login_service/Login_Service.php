<?php

namespace vezit\services\login_service;

require_once __DIR__ . '/../../global-requirements.php';

use vezit\dto\Login_Request;
use vezit\dto\Login_Response;
use vezit\repositories\user_repository\User_Repository;

class Login_Service
{

    public function __construct(
        private User_Repository $_user_repository = new User_Repository(),
        private ?Login_Response $_login_response = null
        )
    {
        // Makes it possible to inject this variable, in unit testing.
        if (null === $this->_login_response) {
            if (isset($_SESSION['login_response']))
                $this->_login_response = unserialize($_SESSION['login_response']);
            else
                $this->_login_response = new Login_Response(null,false,false,'Default message from default instantiantion');
        }
    }



    public function validate_user_credentials(Login_Request $login_request): Login_Response {

        // If user is already logged in
        if ($this->_login_response->access_granted){
            $this->_login_response->message = "You were already logged in";
            return $this->_login_response;
        }


        $access_granted = false;
        $users = $this->_user_repository->get_all();

        $user = null;
        foreach ($users->get() as $pk => $u) {
            if ($login_request->email === $u->email) {
                $user = $u;
            }
        }



        if (null !== $user) {
            (bool)$access_granted = password_verify($login_request->password, $user->hashed_password);

        } else {
            return new Login_Response(
                null,
                null,
                null,
                "Email ($login_request->email) does not exist"
            );
        }


        $login_response = new Login_Response(
            $user->email,
            $access_granted,
            isset($_SESSION['login_response']),
            "You have successfully logged in"
        );

        if (!(isset($_SESSION['login_response'])))
            $_SESSION["login_response"] = serialize($login_response);


        return $login_response;
    }


    public function check_if_user_is_logged_in(): Login_Response
    {


        // If user is already logged in
        if ($this->_login_response->access_granted){
            $this->_login_response->message = "You are logged in";
            return $this->_login_response;
        }

        return new Login_Response(
            null,
            false,
            isset($_SESSION['login_response']),
            "There is no active session - you are not logged in."
        );

    }


    public function logout(): Login_Response
    {
        $this->_login_response = null;

        if (isset($_SESSION['login_response']))
            unset($_SESSION["login_response"]);

        return new Login_Response(
            null,
            false,
            isset($_SESSION['login_response']),
            'You are now logged out'
        );
    }
}
