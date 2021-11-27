<?php

namespace vezit\classes\repositories\user;

require __DIR__.'/../../global-requirements.php';

class User implements IUser {

  private $db_conn;

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

  public function get_by_id(int $id) : object {
    $sql = "SELECT * FROM `User` WHERE User.Id=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = (object)$result->fetch_assoc();
    return $user;
  }

  public function get_by_email(string $email) : object {
    $sql = "SELECT * FROM `User` WHERE User.Email=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = (object)$result->fetch_assoc();
    return $user;
  }

  public function get_by_role(string $email) : object {
    return new stdClass;
  }
  
}