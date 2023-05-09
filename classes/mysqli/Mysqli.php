<?php

namespace vezit\classes\mysqli;

use vezit\classes\error\Error;

class Mysqli
{
    private $_db_conn = null;

    // ------------ SINGLETON PATTERN STARTS HERE -------------- //

    // Declare static properties
    private static int $_times_instantiated = 0;
    private static ?Mysqli $_instance = null;
    
    // Return a new instance if not already instantiated
    public static function get_instance(string $db_host = null, string $db_user = null, string $db_pass = null, string $db_name = null)
    {
        // Create new instance if not already instantiated
        if (null === self::$_instance) {
            self::$_instance = new Mysqli($db_host, $db_user, $db_pass, $db_name);
        }

        return self::$_instance;
    }

    private function __construct(private $_db_host = null, private $_db_user  = null, private $_db_pass = null, private $_db_name = null)
    {














        // Check if the global connection is not set, then throw an exception
        try {
            global $g_db_conn;
            if (null === $g_db_conn) {
                throw new \Exception('Global connection is not set');
            }
        } catch (\Exception $e) {
            // Determine if the execution is coming from a unit test
            $trace = debug_backtrace();
            $is_unit_test = false;
            foreach ($trace as $step) {
                if (isset($step['class']) && strpos($step['class'], 'PHPUnit\\') === 0) {
                    $is_unit_test = true;
                    break;
                }
            }

            // Log the error message if it's not a unit test
            if (!$is_unit_test) {
                Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
            }

            // Rethrow the exception
            throw $e;
        }



























        // Try to connect to the database
        // If the connection fails, then throw an exception
        try {
            if ($this->_db_host && $this->_db_user && $this->_db_pass && $this->_db_name) {
                // If all the parameters are passed in, it means that you want to use a different database
                // This is useful for testing. For example, you can use this part of code to point to another database:
                // Super_Repository::get_instance(
                //     Mysqli::get_instance(
                //         'database-service',
                //         'testuser',
                //         'Passw0rd',
                //         $g_db_conn->dbname
                //     )
                // )
                
                $this->_db_conn = new \mysqli($this->_db_host, $this->_db_user, $this->_db_pass, $this->_db_name);

            } else {
                // Otherwise, the constructor will just use the global connection, which is useful for production and non-unit testing
                global $g_db_conn;
                $this->_db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
            }

            // If the connection failed, then throw an exception
            if ($this->_db_conn->connect_error) {
                throw new \Exception('Connection failed: ' . $this->_db_conn->connect_error);
            }
        } catch (\Exception $e) {
            // Determine if the execution is coming from a unit test
            $trace = debug_backtrace();
            $is_unit_test = false;
            foreach ($trace as $step) {
                if (isset($step['class']) && strpos($step['class'], 'PHPUnit\\') === 0) {
                    $is_unit_test = true;
                    break;
                }
            }

            // Log the error message if it's not a unit test
            if (!$is_unit_test) {
                Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
            }

            // Rethrow the exception
            throw $e;
        }














        // Increment the number of times the class has been instantiated
        // I made this to see how many times the class has been instantiated, ideally it should only be instantiated once
        self::$_times_instantiated++;
    }

    public function destroy_instance()
    {
        self::$_instance = null;
    }

    // Prevent the instance from being cloned
    private function __clone()
    {
    }

    // ------------ SINGLETON PATTERN ENDS HERE -------------- //

    public function get_db_conn()
    {
        return $this->_db_conn;
    }
}
