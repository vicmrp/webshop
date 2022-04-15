<?php

namespace vezit\classes\mysqli;

class Mysqli
{
    private $db_conn = null;

    function __construct()
    {
        // -- sql -- //
        global $g_db_conn;
        $this->db_conn = new \Mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
        if ($this->db_conn->connect_error) {
            die("Connection failed: " . $this->db_conn->connect_error); // Check connection
        }
        // -- sql -- //
    }

    function get_db_conn()
    {
        return $this->db_conn;
    }
}
