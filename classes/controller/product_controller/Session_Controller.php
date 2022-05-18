<?php namespace vezit\classes\controller\product_controller;
require __DIR__.'/../../../global-requirements.php';

use vezit\services\product_service\Product_Service;
use vezit\dto\internal_dtos\json_response\Json_Response;

class Product_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?Product_Service $_product_service = null
    )
    {
        if (null == $_product_service)
            $this->_product_service = Product_Service::get_instance();
    }


    public function get_json_response() : Json_Response {
        switch ($this->_request_method) {
            case 'GET': // Get all products
                return new Json_Response();
              break;
            default:
                return new Json_Response();
            break;
        }
    }
}
