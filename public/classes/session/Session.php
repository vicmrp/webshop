<?php
namespace vezit\classes\session;

require __DIR__.'/../../global-requirements.php';


use vezit\classes\db_conn as Db_Conn;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;

// For hver session oprettes oprettes der en entry i db

class Session extends Db_Conn\Db_Conn implements \JsonSerializable, ISession {

  // private $session_id;
  // -- subclasses -- //
  private $session_id;
  public $customer;
  public $order;
  public $shipment;
  // -- subclasses -- //
  // public $db_conn;

  public function __construct()
  {

    // $this->session_id = rand(1000000,9999999);
    $this->session_id = self::new_session_id();
    // -- subclasses -- //
    $this->customer = new Customer\Customer();
    $this->order = new Order\Order();
    $this->shipment = new Shipment\Shipment();
    // -- subclasses -- //

    // Sets variables for subclasses
    $this->order->set_order_id($this->session_id);


    // -- sql -- //
    global $g_db_conn;
    $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
    if ($this->db_conn->connect_error) {
      die("Connection failed: " . $this->db_conn->connect_error); // Check connection
    }
    // -- sql -- //
    
  }

  public static function new_session_id() : string {
    while (true) {
      break;
    }



    return rand(1000000,9999999);
  }

  public function set_session_id($session_id) : void
  {
    $this->session_id = $session_id;
  }

  public function get_session_id() : string
  {
    return $this->session_id;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
    $all_vars = get_object_vars($this);
    $result = array();
    foreach($all_vars as $key => $value)
    {
      if (($key == "db_conn")) break;      
      $result[$key]=$value;
    }
    return $result;
  }
}
