<?php

namespace vezit\services\user_service;

require_once __DIR__ . '/../../global-requirements.php';

use vezit\dto\post_login_response\Post_Login_Response;
use vezit\dto\post_login_request\Post_Login_Request;
use vezit\repositories\user_repository\User_Repository;
use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\entities\User;
use vezit\dto\put_update_user_request\Put_Update_User_Request;
use vezit\dto\put_update_user_response\Put_Update_User_Response;


class User_Service
{
    private static  $_times_instantiated = 0;
    private static  $_times_destroyed = 0;
    private static  $_instance = null;


    public static function get_instance($user_repository = null, $session_variables_service = null)
    {
        return null === self::$_instance ? new User_Service(

            null ===    $user_repository            ? User_Repository::get_instance()           : $user_repository
            ,null ===   $session_variables_service  ? Session_Variables_Service::get_instance() : $session_variables_service

        ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }


    private function __construct(
        private User_Repository $_user_repository
        ,private Session_Variables_Service  $_session_variables_service
    ) {
        // $this->_login_response = isset($_SESSION["login_response"]) ? unserialize($_SESSION["login_response"]) : new Login_Response;
        self::$_times_instantiated++;
    }



    public function validate_user_credentials(Post_Login_Request $login_request): Post_Login_Response
    {

        // If user is already logged in, return login response. Otherwise check if username and password is correct.
        $login_response = $this->_session_variables_service->get_post_login_response();

        if ($login_response->access_granted) {

            $login_response->message = "You were already logged in - session variable isset";
            return $login_response;
        }

        // User has not been permitted permission so check if password is correct


        $users = $this->_user_repository->get_all()->get();

        $user = g_find_object_by_id($login_request->email, $users);

        // Check if username and password is correct
        if (false !== $user) {
            if (password_verify($login_request->password, $user->hashed_password)) {
                $login_response->email = $login_request->email;
                $login_response->access_granted = true;
                $login_response->message = "Your username and password had a match in the db!";
                $this->_session_variables_service->update_post_login_response($login_response);
            } else {
                $login_response->message = "Email or password does not match.";
            }
        }

        return $this->_session_variables_service->get_post_login_response();
    }


    public function update(Put_Update_User_Request $put_update_user_request) : Put_Update_User_Response
    {
        // $update_user_request = new Update_User_Response($password_has_been_updated = false, $message = "");


        // ------ requires login ------ //
        $login_response = $this->_session_variables_service->post_login_response();

        if (!$login_response->access_granted) {
            return new Put_Update_User_Response($password_has_been_updated = false, $message = "You are not logged in");
        }

        // because you are logged in you should be able to retrive pk
        // ------ requires login ------ //


        $password = $put_update_user_request->new_password;

        // ------ password hashing ------- //
        $options = [
            'cost' => 10,
        ];

        $hashed_password = password_hash("Passw0rd", PASSWORD_BCRYPT, $options);
        // ------ password hashing------

        // ------ create user entity ------ //
        $user = new User(
            $user_pk                  = null,
            $datetime_created         = null,
            $datetime_last_modified   = null,
            $email                    = $login_response->email,
            $hashed_password          = $hashed_password
        );
        // ------ create user entity ------ //


        $password_was_updated = $this->_user_repository->update($login_response->email, $user);

        if ($password_was_updated) {
            return new Put_Update_User_Response($password_has_been_updated = true, $message = "Password was updated");
        } else {
            return new Put_Update_User_Response($password_has_been_updated = false, $message = "Password was not updated");
        }

    }


    public function logout(): Post_Login_Response
    {

        $get_login_response = $this->_session_variables_service->get_post_login_response();
        $get_login_response->message = "user has been logged out";
        $get_login_response->access_granted = false;


        $this->_session_variables_service->update_post_login_response($get_login_response);
        return $this->_session_variables_service->get_post_login_response();

    }
}
