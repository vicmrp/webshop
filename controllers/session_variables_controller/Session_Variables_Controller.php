<?php

namespace vezit\controllers\session_variables_controller;

require __DIR__ . '/../../global-requirements.php';

use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\classes\error\Error;


class Session_Variables_Controller
{
    // ------------ SINGLETON PATTERN STARTS HERE -------------- //

    private static $_instance = null;

    public static function get_instance(
        string $request_method,
        ?array $url_parameters = null,
        ?string $body = null,
        ?Session_Variables_Service $session_variables_service = null
    ) {
        if (null === self::$_instance) {
            self::$_instance = new Session_Variables_Controller(
                $request_method,
                $url_parameters,
                $body,
                $session_variables_service ?? Session_Variables_Service::get_instance()
            );
        }
        return self::$_instance;
    }

    public static function destroy_instance()
    {
        self::$_instance = null;
    }

    private function __construct(
        private string $_request_method,
        private ?array $_url_parameters,
        private ?string $_body,
        private Session_Variables_Service $_session_variables_service
    ) {
    }

    // ------------ SINGLETON PATTERN ENDS HERE -------------- //


    public function get_json_response(): string
    {
        try {
            switch ($this->_request_method) {
                case 'GET':
                    // handle GET requests
                    break;
                case 'PUT':
                    // handle PUT requests
                    break;
                case 'POST':
                    // handle POST requests
                    break;
                case 'DELETE':
                    if ('delete-all-session-variables-request' === $this->_url_parameters['query']) {
                        // handle DELETE requests for deleting all session variables
                        $delete_session_variables_response = $this->_session_variables_service->delete_delete_all_session_variables();
    
                        $response = new \stdClass;
    
                        $response->delete_session_variables_response = $delete_session_variables_response;
    
                        return json_encode($response, JSON_PRETTY_PRINT);
                    } else {
                        throw new \Exception('Invalid DELETE request', 400);
                    }
                    break;
                default:
                    throw new \Exception('Invalid request method', 400);
            }
        } catch (\Exception $e) {
            // Log the error message in the apache error log
            Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
    
            // Check if the server is in sandbox mode
            global $g_sandbox_mode_enabled;
            if ($g_sandbox_mode_enabled) {
                // If the server is in sandbox mode, display the error message and callstack to the client
                // This is useful for debugging
                $errorJson = Error::toJson($e->getCode(), $e->getMessage(), [
                    "callstack" => $e->getTraceAsString(),
                    "file" => $e->getFile()
                ]);
                return $errorJson;
            } else {
                // If the server is not in sandbox mode, display a generic error message to the client
                // This is to prevent sensitive information from being displayed to the client
                return 'Internal server error';
            }
        }
    }
}
