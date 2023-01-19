<?php namespace vezit\controllers\session_controller;
require __DIR__.'/../../global-requirements.php';

use stdClass;
use vezit\services\session_service\Session_Service;

use vezit\dto\put_update_customer_request\Put_Update_Customer_Request;


use vezit\dto\put_update_order_items_request\Put_Update_Order_Items_Request;
use vezit\dto\put_update_order_items_request\Item;
use vezit\dto\put_update_shipment_request\Put_Update_Shipment_Request;

class Session_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string  $request_method,
        array   $url_parameters = null,
        ?string $body = null,
        ?Session_Service $session_service = null
    ) {
        return (null === self::$_instance) ? new Session_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $session_service ? Session_Service::get_instance() : $session_service
        ) : self::$_instance;
    }

    public static function destroy_instance() {
        self::$_instance = null;
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private Session_Service $_session_service
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }

    public function get_json_response() : string {
        switch ($this->_request_method) {


            // --------- GET --------- //
            case 'GET' && 'get-session-request' === $this->_url_parameters['query']: // Get the service

                $order_id = isset($this->_url_parameters['order_id']) ? $this->_url_parameters['order_id'] : null;
                // if order id is not 20 characters long, then it is not a valid order id
                global $g_order_id_length;
                if (null !== $order_id && $g_order_id_length !== strlen($order_id)) {
                    $order_id = null;
                }


                $get_session_response = $this->_session_service->get_session($order_id);

                $response = new stdClass;

                $response->get_session_response = $get_session_response;

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;





























            case 'GET' && 'get-payment-link-request' === $this->_url_parameters['query']:

                $response = new \stdClass;

                $response->get_payment_link_response = $this->_session_service->get_payment_link();

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;

            // --------- GET --------- //





            // --------- PUT --------- //
            case 'PUT' && 'put-update-customer-request' === $this->_url_parameters['query']: // Update the service

                $std_object = json_decode($this->_body)->put_update_customer_request;

                $put_update_customer_request = g_generate_multidimensional_dto_from_web_request($std_object, Put_Update_Customer_Request::class, $null_is_not_allowed = false);

                $response = new \stdClass;

                $response->put_update_customer_response = $this->_session_service->update_customer($put_update_customer_request);

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;




            case 'PUT' && 'put-update-order-items-request' === $this->_url_parameters['query']:


                // ---- sanitize data ---- //
                $unsanitized_put_update_order_items_request = json_decode($this->_body)->put_update_order_items_request;

                $sanitized_items = array_map(function($item) {
                    return g_generate_multidimensional_dto_from_web_request($item, Item::class);
                }, $unsanitized_put_update_order_items_request->items);


                $put_update_order_items_request = new Put_Update_Order_Items_Request;
                $put_update_order_items_request->set_items($sanitized_items);
                // ---- sanitize data ---- //



                // ---- check that data is legal ---- //
                foreach ($put_update_order_items_request->get_items() as $item) {
                    if (0 >= $item->product_pk)
                        throw new \Exception("Data is invalid", 1);

                    if (-1 === $item->quantity)
                        throw new \Exception("Data is invalid", 1);
                }
                // ---- check that data is legal ---- //


                $response = new \stdClass;

                $response->put_update_order_items_response = $this->_session_service->update_order($put_update_order_items_request);

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;



            case 'PUT' && 'put-update-shipment-request' === $this->_url_parameters['query']:

                $unsanitized_object = json_decode($this->_body)->put_update_shipment_request;

                $put_update_shipment_request = g_generate_multidimensional_dto_from_web_request(
                    $unsanitized_object
                    ,Put_Update_Shipment_Request::class
                );


                $response = new \stdClass;

                $response->put_update_shipment_response = $this->_session_service->update_shipment($put_update_shipment_request);

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;

            // --------- PUT --------- //









            // --------- POST --------- //
            case 'POST': // Commit e.g go to payment, or choose postal_service_lokation
                return "";
            // --------- POST --------- //








            // --------- DELETE --------- //
            // --------- DELETE --------- //







            default:
                throw new \Exception("Error Processing Request", 1);
        }
    }
}
