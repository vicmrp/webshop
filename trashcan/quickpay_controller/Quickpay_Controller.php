<?php namespace vezit\controllers\quickpay_controller;
require __DIR__.'/../../global-requirements.php';

use vezit\services\quickpay_service\Quickpay_Service;


class Quickpay_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?array $_url_parameters = null,
        private ?string $_body = null,
        private ?Quickpay_Service $_quickpay_service = null
    )
    {
    }


    public function get_json_response() : string {
        switch ($this->_request_method) {
            case 'GET': // Get payment link
                $ = $this->_quickpay_service->get_payment_link();
                $json = json_encode($products, JSON_PRETTY_PRINT);
                return $json;
            break;
            default:
                return "";
            break;
        }
    }
}
