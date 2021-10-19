<?php

namespace vezit\classes\db_conn;



require __DIR__.'/../../global-requirements.php';

class Db_Conn {

  protected $db_conn;
  

  // Create connection
  public function __construct() { 

    // -- sql -- //
    global $g_db_conn;
    $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
    if ($this->db_conn->connect_error) {
      die("Connection failed: " . $this->db_conn->connect_error); // Check connection
    }
    // -- sql -- //
  }


}


// $db_conn = new Db_Conn();

// $db_conn->create(122134);