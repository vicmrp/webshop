<?php
namespace vezit\classes\session;

require __DIR__.'/../../global-requirements.php';


use vezit\classes\db_conn as Db_Conn;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

// For hver session oprettes oprettes der en entry i db

class Session extends Db_Conn\Db_Conn implements \JsonSerializable {

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
    global $g_db_conn;
    $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
    if ($this->db_conn->connect_error) {
      die("Connection failed: " . $this->db_conn->connect_error); // Check connection
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
  public function jsonSerialize($excluded_objects = array())
  {
    $all_vars = get_object_vars($this);
    $result = array();
    foreach($all_vars as $key => $value) {
      foreach($excluded_objects as $excluded_object) {
        if (! ($key == $excluded_object)) {
          $result[$key]=$value;
        }
        $result[$key]=$value;
      }
      return $result;

      // for ($i=0; $i <= 0; $i++) { 
      //   if (!($key == $exclude_objects[$i]))
      //   {
      //     echo $exclude_objects[$i];
      //     var_dump($key);
      //   }
        
      // }
    }
    // return $result;
  }
}




$x = new Session();

var_dump($x->jsonSerialize());