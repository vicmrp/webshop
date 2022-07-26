<?php namespace vezit\controllers\product_controller;
require __DIR__.'/../../global-requirements.php';

use vezit\services\product_service\Product_Service;


class Product_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string  $request_method,
        ?array  $url_parameters = null,
        ?string $body = null,
        Product_Service $product_service = null
    )
    {
        return (null === self::$_instance) ? new Product_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $product_service ? Product_Service::get_instance() : $product_service
        ) : self::$_instance;
    }

    public static function destroy_instance() {
        self::$_instance = null;
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private Product_Service $_product_service
    )
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }


    public function get_json_response() : string {
        switch ($this->_request_method) {
            case 'GET': // Get all products
                $products = $this->_product_service->get_all();
                $json = json_encode($products, JSON_PRETTY_PRINT);
                return $json;
            break;
            default:
                return "";
            break;
        }
    }
}
