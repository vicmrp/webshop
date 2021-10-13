<?php
namespace vezit\classes\mysql;
// require_once __DIR__.'/../../global-requirements.php';
class Mysql {
  protected $servername = "localhost";
  protected $username   = "user";
  protected $password   = "ovXWUUUnmZYNXZTA";
  protected $dbname     = "user_steengede_com";
  protected $mysqli;

  // Create connection
  public function __construct() {    
    // // -- sql -- //
    // $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    // if ($this->mysqli->connect_error) {
    //   die("Connection failed: " . $this->mysqli->connect_error); // Check connection
    // }
    // // -- sql -- //
  }

  public function test()
  {
    return $this->dbname;
  }
}