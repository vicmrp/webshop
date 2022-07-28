<?php

namespace vezit\controllers\postnord_controller;

require __DIR__ . '/../../global-requirements.php';

use vezit\services\postnord_service\Postnord_Service;


class Postnord_Controller
{

    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string $request_method,
        array  $url_parameters = null,
        ?string $body = null,
        Postnord_Service $postnord_service = null
    ) {
        return (null === self::$_instance) ? new Postnord_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $postnord_service ? Postnord_Service::get_instance() : $postnord_service
        ) : self::$_instance;
    }

    public static function destroy_instance()
    {
        self::$_instance = null;
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private Postnord_Service $_postnord_service
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }



    public function get_json_response(): string
    {
        switch ($this->_request_method) {

            // --------- GET --------- //
            case 'GET' && 'get-service-points' === $this->_url_parameters['query']: //


                // Signature http://localhost/api/postnord/?streetname=vinkelvej&zip-code=2800
                return json_encode(
                    $this->_postnord_service->get_service_points(
                        $street_name_and_house_number = urldecode($this->_url_parameters['streetname'])
                            ? isset($this->_url_parameters['streetname']) : throw new \Exception("Error Processing Request", 1),
                        $postal_code = urldecode($this->_url_parameters['zip-code'])
                            ? isset($this->_url_parameters['zip-code']) : throw new \Exception("Error Processing Request", 1)
                    ),
                    JSON_PRETTY_PRINT
                );
            // --------- GET --------- //




            default:
                return "";
        }
    }
}
