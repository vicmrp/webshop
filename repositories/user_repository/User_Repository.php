<?php

namespace vezit\repositories\user_repository;

require __DIR__.'/../../global-requirements.php';

use vezit\entities\user as Entity;
use vezit\classes\error as Error;

class User_Repository implements IUser_Repository {

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

  public function get_user_by_id(int $id) : object {
    $sql = "SELECT * FROM `User` WHERE User.Id=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = (object)$result->fetch_assoc();
    return $user;
  }

  public function get_user_by_email(string $email) : Entity\User {
    $sql = "SELECT * FROM `User` WHERE User.Email=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0) {
      $error_message = "get_user_by_email '$email' does not exist in database: ";
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
    }

    $entity = $result->fetch_assoc();
        
    $user = new Entity\User();
    $user->id = $entity['Id'];
    $user->email = $entity['Email'];
    $user->hash = $entity['Hash'];
    $user->role = $entity['Role'];

    return $user;
  }

  public function get_user_by_role(string $email) : object {
    return (object)"";
  }
}
