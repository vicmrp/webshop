<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\controllers\session_controller\Session_Controller;
use vezit\classes\error\Error;


try {
    $json_response =  Session_Controller::get_instance(
        $request_method = $_SERVER['REQUEST_METHOD'],
        $url_parameters = $_GET,
        $body = file_get_contents('php://input'))->get_json_response();
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
            echo $errorJson;
            exit;
        } else {
            // If the server is not in sandbox mode, display a generic error message to the client
            // This is to prevent sensitive information from being displayed to the client
            echo 'Internal server error';
            exit;
        }
    }



echo $json_response;
