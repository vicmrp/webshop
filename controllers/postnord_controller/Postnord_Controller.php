<?php namespace vezit\controllers\postnord_controller;

require __DIR__.'/../../global-requirements.php';

use vezit\services\postnord_service\Postnord_Service;


class Postnord_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?array  $_url_parameters = null,
        private ?string $_body = null,
        private ?Postnord_Service $_postnord_service = null
    )
    {
        if (null == $_postnord_service)
            $this->_postnord_service = Postnord_Service::get_instance();
    }



    public function get_json_response() : string {
        switch ($this->_request_method) {
            case 'GET': //

                // Signature http://localhost/api/postnord/?streetname=vinkelvej&zip-code=2800
                if (isset($this->_url_parameters['streetname']) && isset($this->_url_parameters['zip-code'])) {

                    $service_points = $this->_postnord_service->get_service_points(
                        $street_name_and_house_number = urldecode($this->_url_parameters['streetname']),
                        $postal_code = urldecode($this->_url_parameters['zip-code'])
                    );


                    $json = json_encode($service_points, JSON_PRETTY_PRINT);
                    return $json;
                }




            break;
            default:
                return "";
            break;
        }
    }

}
