<?php

require __DIR__.'/../../global-requirements.php';

use vezit\classes\db_conn as Db_Conn;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

class MyClass extends Db_Conn\Db_Conn implements \JsonSerializable
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

// $mysql = new Db_Conn\Db_Conn();
// echo $mysql->test();


$myClass = new MyClass();
echo $myClass->test();
// $x = new MyClass();

// echo $x->myFunc2();