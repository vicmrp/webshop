<?php namespace vezit\controllers\session_controller;
require __DIR__.'/../../global-requirements.php';

use PhpParser\Node\Expr\New_;
use vezit\dto\Session_Update_Customer_Request;
use vezit\services\session_service\Session_Service;
use vezit\models\json_response\Json_Response;
use vezit\dto\Session_Order_Update_Request;
use vezit\dto\Session_Order_Update_Requests;
use vezit\dto\update_customer_request\Update_Customer_Request;

class Session_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string  $request_method,
        array   $url_parameters = null,
        ?string $body = null,
        ?Session_Service $session_service = null
    )
    {
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
    )
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }

    public function get_json_response() : string {
        switch ($this->_request_method) {


            // --------- GET --------- //
            case 'GET' && 'get-session' === $this->_url_parameters['query']: // Get the service
                return json_encode(
                    $this->_session_service->get_session()
                    ,JSON_PRETTY_PRINT
                );

            case 'GET' && 'get-payment-link' === $this->_url_parameters['query']:
                return json_encode(
                    $this->_session_service->get_payment_link()
                    ,JSON_PRETTY_PRINT
                );


            // --------- GET --------- //





            // --------- PUT --------- //
            case 'PUT' && 'update-customer' === $this->_url_parameters['query']: // Update the service
                return json_encode(
                    $this->_session_service->update_customer(
                        g_generate_multidimensional_dto_from_web_request(
                            json_decode($this->_body)->customer
                            ,Update_Customer_Request::class
                        )
                    )
                    ,JSON_PRETTY_PRINT
                );




            case 'PUT' && 'update-order-items' === $this->_url_parameters['query']:
                $array_of_order_update_request = [];
                $session_order_update_requests = new Session_Order_Update_Requests;
                foreach ((array)json_decode($this->_body) as $object) {
                    array_push($array_of_order_update_request, g_generate_multidimensional_dto_from_web_request($object, Session_Order_Update_Request::class));
                }
                $session_order_update_requests->set($array_of_order_update_request);
                return json_encode(
                    $this->_session_service->update_order($session_order_update_requests)
                    ,JSON_PRETTY_PRINT
                );


            case 'PUT' && 'update-shipment' === $this->_url_parameters['query']:
                return json_encode(
                    $this->_session_service->update_shipment(
                        $this->_url_parameters['service-point-id']
                    )
                    ,JSON_PRETTY_PRINT
                );
            // --------- PUT --------- //









            // --------- POST --------- //
            case 'POST': // Commit e.g go to payment, or choose postal_service_lokation
                return "";
            // --------- POST --------- //








            // --------- DELETE --------- //
            case 'DELETE' && 'delete-session' === $this->_url_parameters['query']: // Destroy the service
                return json_encode(
                    $this->_session_service->unset_session()
                    ,JSON_PRETTY_PRINT
                );
            // --------- DELETE --------- //







            default:
                return "";

        }
    }
}
