<?php
namespace vezit\classes\session;

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\mysql as Mysql;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

// For hver session oprettes oprettes der en entry i db

class Session extends Mysql\Mysql implements \JsonSerializable {

  
  // private $session_id;
  // -- subclasses -- //
  public $customer;
  public $order;
  public $shipment;
  // -- subclasses -- //

  public function __construct() {
  

    // $this->session_id = rand(1000000,9999999);
    // -- subclasses -- //
    $this->customer = new Customer\Customer();
    $this->order = new Order\Order();
    $this->shipment = new Shipment\Shipment();
    // -- subclasses -- //

    // -- sql -- //
    $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($this->mysqli->connect_error) {
      // Check connection
      die("Connection failed: " . $this->mysqli->connect_error);
    }
    // -- sql -- //
  }

  public function set_session_id($session_id)
  {
    $this->session_id = $session_id;
  }

  public function get_session_id()
  {
    return $this->session_id;
  }

  public function set_customer($customer)
  {
    $this->customer = $customer;
  }

  public function set_shipment($shipment)
  {
    $this->shipment = $shipment;
  }

  public function set_order($order)
  {
    $this->order = $order;
  }

  public function set_quickpay($quickpay)
  {
    $this->quickpay = $quickpay;
  }



  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
    $vars = get_object_vars($this);
    return $vars;
  }
}


