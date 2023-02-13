<?php namespace vezit\controllers\session_variables_controller;
require __DIR__.'/../../global-requirements.php';

use stdClass;
// use vezit\dto\Session_Update_Customer_Request;
// use vezit\services\session_service\Session_Service;
// use vezit\models\json_response\Json_Response;
// use vezit\dto\Session_Order_Update_Request;
use vezit\services\session_variables_service\Session_Variables_Service;

// use vezit\dto\put_update_order_request\Put_Update_Order_Request;
// use vezit\dto\put_update_customer_request\Put_Update_Customer_Request;

// use vezit\dto\put_update_order_items_request\Put_Update_Order_Items_Request;
// use vezit\dto\put_update_order_items_request\Item;

use vezit\dto\update_shipment_request\Update_Shipment_Request;

class Session_Variables_Controller
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(
        string  $request_method,
        array   $url_parameters = null,
        ?string $body = null,
        ?Session_Variables_Service $session_variables_service = null
    ) {
        return (null === self::$_instance) ? new Session_Variables_Controller(
            $request_method,
            $url_parameters,
            $body,
            null === $session_variables_service ? Session_Variables_Service::get_instance() : $session_variables_service
        ) : self::$_instance;
    }

    public static function destroy_instance() {
        self::$_instance = null;
    }


    private function __construct(
        private string $_request_method,
        private ?array  $_url_parameters,
        private ?string $_body,
        private Session_Variables_Service $_session_variables_service
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }

    public function get_json_response() : string {
        switch ($this->_request_method) {


            // --------- GET --------- //
            // --------- GET --------- //





            // --------- PUT --------- //
            // --------- PUT --------- //









            // --------- POST --------- //
            // --------- POST --------- //








            // --------- DELETE --------- //
            case 'DELETE' && 'delete-all-session-variables-request' === $this->_url_parameters['query']: // Destroy the service

                $delete_session_variables_response = $this->_session_variables_service->delete_delete_all_session_variables();

                $response = new \stdClass;

                $response->delete_session_variables_response = $delete_session_variables_response;

                $string = json_encode($response, JSON_PRETTY_PRINT);

                return $string;
            // --------- DELETE --------- //







            default:
                throw new \Exception("Error Processing Request", 1);
        }
    }
}
