<?php namespace vezit\controllers\login_controller;

use vezit\services\login_service\Login_Service;

class Login_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string $request_method,
        ?array  $url_parameters = null,
        ?string $body = null,
        Login_Service $login_service = null
    )
    {
        return (null === self::$_instance) ? new Login_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $login_service ? Login_Service::get_instance() : $login_service
        ) : self::$_instance;
    }

    public static function destroy_instance() {
        self::$_instance = null;
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private Login_Service $_login_service
    )
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }
}
