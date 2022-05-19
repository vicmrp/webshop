<?php namespace vezit\classes\controller\session_controller;
require __DIR__.'/../../../global-requirements.php';

use vezit\services\session_service\Session_Service;
use vezit\dto\internal_dtos\json_response\Json_Response;

class Session_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?Session_Service $_session_service = null
    )
    {
        if (null == $_session_service)
            $this->_session_service = Session_Service::get_instance();
    }


    public function get_json_response() : Json_Response {
        switch ($this->_request_method) {
            case 'GET': // Get the service
                return new Json_Response($this->_session_service->get_session());
              break;
            case 'PUT': // Update the service
                // What to update? What to do?
                return new Json_Response($this->_session_service->get_session());
              break;
            case 'POST': // Commit e.g go to payment, or choose postal_service_lokation
                return new Json_Response($this->_session_service->get_session());
              break;
            case 'DELETE': // Destroy the service
                return new Json_Response($this->_session_service->unset_session());
            break;
            default:
                return new Json_Response();
            break;
        }
    }
}
