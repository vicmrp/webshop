<?php namespace vezit\controllers\session_controller;
require __DIR__.'/../../global-requirements.php';

use PhpParser\Node\Expr\New_;
use vezit\dto\Session_Update_Customer_Request;
use vezit\services\session_service\Session_Service;
use vezit\models\json_response\Json_Response;
use vezit\dto\Session_Order_Update_Request;
use vezit\dto\Session_Order_Update_Requests;

class Session_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string $request_method,
        ?array  $url_parameters = null,
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
            case 'GET': // Get the service
                $session = $this->_session_service->get_session();
                $json = json_encode($session, JSON_PRETTY_PRINT);
                return $json;
              break;
            case 'PUT': // Update the service


                if ($this->_url_parameters['update'] == 'customer') {
                    $customer = json_decode($this->_body)->customer;
                    $session = $this->_session_service->update_customer($customer);
                    $json = json_encode($session, JSON_PRETTY_PRINT);
                    return $json;
                }

                else if ($this->_url_parameters['update'] == 'order') {
                    $array_incoming_data = json_decode($this->_body);
                    $array_result = [];
                    foreach ($array_incoming_data as $object) {
                        array_push($array_result, g_generate_flat_dto_from_web_request($object, Session_Order_Update_Request::class));
                    }

                    $session_order_update_requests = new Session_Order_Update_Requests;

                    $session_order_update_requests->set($array_result);

                    $session_response = $this->_session_service->update_order($session_order_update_requests);

                    return json_encode($session_response);


                    // // $session = $this->_session_service->update_order($order);
                    // $json = json_encode($session, JSON_PRETTY_PRINT);
                    // return $json;
                }

                else if (($this->_url_parameters['update'] == 'shipment') && (null !== $this->_url_parameters['service-point-id'])) {
                    $session = $this->_session_service->update_shipment($this->_url_parameters['service-point-id']);
                    $json = json_encode($session, JSON_PRETTY_PRINT);
                    return $json;
                }

              break;
            case 'POST': // Commit e.g go to payment, or choose postal_service_lokation
                return "";
              break;
            case 'DELETE': // Destroy the service
                $session_delete_response =  $this->_session_service->unset_session();
                $json = json_encode($session_delete_response, JSON_PRETTY_PRINT);
                return $json;
            break;
            default:
                return "";
            break;
        }
    }
}
