<?php namespace vezit\controllers\session_controller;
require __DIR__.'/../../global-requirements.php';

use vezit\dto\Session_Update_Customer_Request;
use vezit\services\session_service\Session_Service;
use vezit\models\json_response\Json_Response;

class Session_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?array  $_url_parameters = null,
        private ?string $_body = null,
        private ?Session_Service $_session_service = null
    )
    {
        if (null == $_session_service)
            $this->_session_service = Session_Service::get_instance();
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

                if ($this->_url_parameters['update'] == 'order') {
                    $order = json_decode($this->_body)->order;
                    $session = $this->_session_service->update_order($order);
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
