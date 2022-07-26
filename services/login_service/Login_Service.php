<?php

namespace vezit\services\login_service;

require_once __DIR__ . '/../../global-requirements.php';

use vezit\dto\Login_Request;
use vezit\dto\Login_Response;
use vezit\repositories\user_repository\User_Repository;

class Login_Service
{
    private static  $_times_instantiated = 0;
    private static  $_instance = null;
    private         $_login_response;


    public static function get_instance($user_repository = null)
    {
        return null === self::$_instance ? new Login_Service(

            null === $user_repository ? User_Repository::get_instance() : $user_repository

        ) : self::$_instance;
    }


    private function __construct(
        private User_Repository $_user_repository
    ) {
        $this->_login_response = isset($_SESSION["login_response"]) ? unserialize($_SESSION["login_response"]) : new Login_Response;
        self::$_times_instantiated++;
    }



    public function validate_user_credentials(Login_Request $login_request): Login_Response
    {

        // If user is already logged in, return login response. Otherwise check if username and password is correct.
        if ($this->_login_response->access_granted) {

            $this->_login_response->message = "You were already logged in - session variable isset";

        } else {

            $users = $this->_user_repository->get_all();
            foreach ($users->get() as $user_pk => $user) {
                if ($login_request->email === $user->email && password_verify($login_request->password, $user->hashed_password)) {
                    $this->_login_response->email = $user->email;
                    $this->_login_response->access_granted = true;
                    $this->_login_response->message = "Your username and password had a match in the db!";
                    break;
                } else {
                    $this->_login_response->email = $user->email;
                    $this->_login_response->access_granted = false;
                    $this->_login_response->message = "Your username and password had no match in the db!";
                }
            }
        }



        $_SESSION['login_response'] = serialize($this->_login_response);
        return unserialize($_SESSION['login_response']);

    }


    public function logout(): Login_Response
    {

        if (isset($_SESSION['login_response'])) unset($_SESSION["login_response"]);

        return new Login_Response(
            null,
            false,
            isset($_SESSION['login_response']),
            'You are now logged out'
        );
    }
}
