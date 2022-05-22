<?php

namespace vezit\services\postnord_service;

use vezit\api\dawa_api\Dawa_API;
use vezit\api\postnord_api\Postnord_API;
use vezit\classes\api\postnord\Postnord;
use vezit\services\session_service\Session_Service;

require __DIR__.'/../../global-requirements.php';

class Postnord_Service
{
    private static $_instance = null;
    private Postnord_API $_postnord_api;
    private Dawa_API $_dawa_api;

    private function __construct(Postnord_API $postnord_API, Dawa_API $dawa_api) {
        $this->_postnord_api = $postnord_API;
        $this->_dawa_api = $dawa_api;
    }

    public static function get_instance(Postnord_API $postnord_api = new Postnord_API, Dawa_API $dawa_api = new Dawa_API)
    {

        if (self::$_instance == null) {
            self::$_instance = new Postnord_Service($postnord_api, $dawa_api);
        }

        return self::$_instance;
    }

    public static function delete_instance() {
        self::$_instance = null;
    }














    public function get_service_points(string $streetname, string $postal_code) : array
    {

        $sanitized_address = $this->_dawa_api->call_get_sanitized_address(
            $streetname,
            $postal_code
        );

        $array_of_service_points = $this->_postnord_api->call_get_servicepoints($sanitized_address);


        return $array_of_service_points;
    }

}