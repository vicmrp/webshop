<?php


namespace vezit\classes\error;


class Error {

    // Do not allow this class to be instantiated
    private function __construct() {}



    // ------------ PUBLIC METHODS -------------- //
    // put into apache error log
    public static function log($message) : void {
        error_log('Error: ' . $message);
    }

    /**
     * Converts an error code and message into a JSON string.
     *
     * @param int $code The error code.
     * @param string $message The error message.
     * @param array $additional_properties Optional additional properties to include in the error object.
     * @return string The JSON-encoded error object.
     */
    public static function toJson(int $code, string $message, array $additional_properties = []): string {
        // Create an array with the error code and message.
        $error = [
            "error" => [
                "code" => $code,
                "message" => $message
            ]
        ];

        // If additional properties were provided, add them to the error object.
        if (!empty($additional_properties)) {
            $error["error"] += $additional_properties;
        }

        // Encode the error object as JSON and return it.
        return json_encode($error, JSON_PRETTY_PRINT);
    }
    // ------------ PUBLIC METHODS -------------- //
}