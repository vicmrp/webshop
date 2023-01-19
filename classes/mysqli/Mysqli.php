<?php

namespace vezit\classes\mysqli;

class Mysqli
{
    private $_db_conn = null;
    private static $_times_instantiated = 0;
    private static $_instance = null;




    // Return a new instance if not already instantiated
    public static function get_instance(string $db_host = null, string $db_user = null, string $db_pass = null, string $db_name = null)
    {
        // Create new instance if not already instantiated
        return (null === self::$_instance ) ? new Mysqli($db_host, $db_user, $db_pass, $db_name) : self::$_instance;
    }

    private function __construct(private $_db_host = null, private $_db_user  = null, private $_db_pass = null, private $_db_name = null)
    {
        global $g_db_conn;
        $this->_db_conn = ($this->_db_host && $this->_db_user && $this->_db_pass && $this->_db_name) ?
            new \mysqli($this->_db_host, $this->_db_user, $this->_db_pass, $this->_db_name)         :
            new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);

        self::$_times_instantiated++;
    }

    public function get_db_conn()
    {
        return $this->_db_conn;
    }
}
