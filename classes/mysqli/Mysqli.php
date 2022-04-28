<?php

namespace vezit\classes\mysqli;

class Mysqli
{
    private $db_conn = null;

    function __construct(private $db_host = null, private $db_user  = null, private $db_pass = null, private $db_name = null)
    {
        if ($this->db_host && $this->db_user && $this->db_pass && $this->db_name) {
            $this->db_conn = new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        } else {
            global $g_db_conn;
            $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
        }

    }

    function get_db_conn()
    {
        return $this->db_conn;
    }
}
