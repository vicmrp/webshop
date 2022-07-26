<?php

namespace vezit\classes\mysqli;

class Mysqli
{
    private $db_conn = null;
    private static $_times_instantiated = 0;
    private static $_instance = null;





    public static function get_instance(string $db_host = null, string $db_user = null, string $db_pass = null, string $db_name = null)
    {
        return (null === self::$_instance ) ? new Mysqli($db_host, $db_user, $db_pass, $db_name) : self::$_instance;
    }


    private function __construct(private $db_host = null, private $db_user  = null, private $db_pass = null, private $db_name = null)
    {
        global $g_db_conn;
        $this->db_conn = ($this->db_host && $this->db_user && $this->db_pass && $this->db_name) ?
            new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name)         :
            new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);

        self::$_times_instantiated++;
    }

    public function get_db_conn()
    {
        return $this->db_conn;
    }
}
