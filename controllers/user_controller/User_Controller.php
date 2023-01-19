<?php namespace vezit\controllers\user_controller;

use vezit\dto\post_login_request\Post_Login_Request;
use vezit\services\user_service\User_Service;
use vezit\dto\put_update_user_request\Put_Update_User_Request;

class User_Controller
{
    private static  $_times_instantiated = 0;
    private static  $_times_destroyed = 0;
    private static  $_instance = null;


    public static function get_instance(
        string $request_method,
        ?array  $url_parameters = null,
        ?string $body = null,
        User_Service $user_service = null
    )
    {
        return (null === self::$_instance) ? new User_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $user_service ? User_Service::get_instance() : $user_service
        ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private User_Service $_user_service
    )
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }


    public function get_json_response() : string {
        switch ($this->_request_method) {
        // --------- GET --------- //
        case 'GET' && 'get-logout-request' === $this->_url_parameters['query']:


            $post_login_response = $this->_user_service->logout();

            $response = new \stdClass;

            $response->post_login_response = $post_login_response;

            $json = json_encode($response, JSON_PRETTY_PRINT);

            return $json;

        // --------- GET --------- //


        // --------- PUT --------- //
        case 'PUT' && 'put-update-user-request' === $this->_url_parameters['query']:

            $raw_object = json_decode($this->_body)->put_update_user_request;

            $put_update_user_request = g_generate_multidimensional_dto_from_web_request($object_to_be_converted = $raw_object, Put_Update_User_Request::class, $null_is_not_allowed = true);

            $put_update_user_response = $this->_user_service->update($put_update_user_request);

            $response = new \stdClass;

            $response->put_update_user_response = $put_update_user_response;

            $json = json_encode($response, JSON_PRETTY_PRINT);

            return $json;

        // --------- PUT --------- //
        // --------- POST --------- //
        case 'POST' && 'post-login-request' === $this->_url_parameters['query']:
            $raw_object = json_decode($this->_body)->post_login_request;
            $post_login_request = g_generate_multidimensional_dto_from_web_request($object_to_be_converted = $raw_object, Post_Login_Request::class, $null_is_not_allowed = false);
            $post_login_response = $this->_user_service->validate_user_credentials($post_login_request);

            $response = new \stdClass;

            $response->post_login_response = $post_login_response;

            $json = json_encode($response, JSON_PRETTY_PRINT);

            return $json;
        // --------- POST --------- //

        default:
            throw new \Exception("Error Processing Request", 1);
        }
    }
}
