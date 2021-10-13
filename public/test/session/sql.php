<?php

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\mysql as Mysql;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

// class Mysql {
//   protected $servername = "localhost";
//   protected $username   = "user";
//   protected $password   = "ovXWUUUnmZYNXZTA";
//   protected $dbname     = "user_steengede_com";
//   protected $mysqli;

//   // Create connection
//   public function __construct() {    
//     $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
//     if ($this->mysqli->connect_error) {
//       // Check connection
//       die("Connection failed: " . $this->mysqli->connect_error);
//     }
//   }
//   public function myFunc1()
//   {
//     return $this->dbname;
//   }
// }

class MyClass extends Mysql\Mysql implements \JsonSerializable
{
  public function myFunc2()
  {
    return $this->dbname;
  } 

  public function jsonSerialize()
  {
    $vars = get_object_vars($this);
    return $vars;
  }
}

$mysql = new Mysql\Mysql();
echo $mysql->test();


$myClass = new MyClass();
echo $myClass->test();
// $x = new MyClass();

// echo $x->myFunc2();