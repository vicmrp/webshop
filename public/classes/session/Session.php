<?php
namespace vezit\classes\session;

require __DIR__.'/../../global-requirements.php';


use vezit\classes\db_conn as Db_Conn;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\shipment as Shipment;
use vezit\interfaces as I; 

// For hver session oprettes oprettes der en entry i db

class Session extends Db_Conn\Db_Conn implements \JsonSerializable, I\ISession {

  // private $session_id;
  // -- subclasses -- //
  public $customer;
  public $order;
  public $shipment;
  // -- subclasses -- //
  // public $db_conn;

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
    

    // when session is constructed an entity should be created that reflects the session
    $this->create(rand(1000000,9999999));
    // $this->create(1000000);
    $this->get_by_id(1000000);
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
    $all_vars = get_object_vars($this);
    $result = array();
    foreach($all_vars as $key => $value) {
        if (($key == "db_conn")) { break; }
          $result[$key]=$value;
      }
      return $result;
  }

  // ---- ISession ---- //
  public function create(int $x) {


    
    $sql = "INSERT INTO s_session (session_id) VALUES (?)";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $session_id);
    $session_id = $x;

    if (!$stmt->execute()) { // writes error 
      throw new \Exception($this->db_conn->error);
    }
  }

  public function get_by_id($order_id) {
    $sql = "CALL `GetSessionById`(?);";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $session_id);
    $session_id = $order_id;
    if (!$stmt->execute()) { // writes error 
      throw new \Exception($this->db_conn->error);
    }

    $result = $stmt->get_result();
    // if($result->num_rows === 1) die("Hello my world");
    while ($myrow = $result->fetch_assoc()) {
      var_dump($myrow);
      printf("session_id: %s, datetime: %s\n", $myrow['session_id'], $myrow['datetime']);
    }

  }

  public function update_by_id($order_id) {}
  // ---- ISession ---- //
}


// $db_conn = new Db_Conn\Db_Conn();
// $db_conn->create(1111);

$session = new Session();
// var_dump($session);





