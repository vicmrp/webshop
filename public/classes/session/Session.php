<?php
namespace vezit\classes\session;

require __DIR__.'/../../global-requirements.php';


use vezit\classes\db_conn as Db_Conn;
use vezit\classes\session\customer as Customer;
use vezit\classes\session\order as Order;
use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session\shipment as Shipment;


// For hver session oprettes oprettes der en entry i db

class Session implements \JsonSerializable, ISession {
  const MIN_SESSION_ID = 1000000;
  const MAX_SESSION_ID = 9999999;

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

    $this->session_id = self::new_session_id();

    $this->customer = new Customer\Customer();
    $this->order = new Order\Order();
    $this->shipment = new Shipment\Shipment();

    $this->order->set_order_id($this->session_id);

  }

  public static function new_session_id() : string {
    
    function session_id_is_unique(string $session_id) : bool
    {
      $array_of_session_ids = _scandir(_from_top_folder().'/temp_database/session');
      foreach($array_of_session_ids as $file_session_id)
      { 
        if ($session_id == substr($file_session_id, 0, -5)) return false;
      }
      return true;
    }

    while (true) 
    {
      if (session_id_is_unique($new_session_id = strval(rand(1000000, 9999999))))
      {
        return $new_session_id;
      }
    }
  }

  public function set_session_id($session_id) : void
  {
    $this->session_id = $session_id;
  }

  public function get_session_id() : string
  {
    return $this->session_id;
  }

  public function construct_session_from_repository(object $session) : void 
  {
    $this->session_id = $session->session_id;
    
    $this->customer->set_fullname($session->customer->fullname);
    $this->customer->contact->set_phone($session->customer->contact->phone);
    $this->customer->contact->set_email($session->customer->contact->email);
    $this->customer->address->set_street($session->customer->address->street);
    $this->customer->address->set_postal_code($session->customer->address->postal_code);
    $this->customer->address->set_city($session->customer->address->city);
    $this->customer->company->set_cvr_number($session->customer->company->cvr_number);
    $this->customer->company->set_company_name($session->customer->company->company_name);

    $this->order->set_order_id($session->order->order_id);
    $this->order->order_status->payment->set_accepted($session->order->order_status->payment->accepted);
    $this->order->order_status->payment->set_amount($session->order->order_status->payment->amount);
    $this->order->order_status->email->set_confirmation_sent($session->order->order_status->email->confirmation_sent);
    $this->order->order_status->email->set_invoice_sent($session->order->order_status->email->invoice_sent);
    $this->order->set_order_items($session->order->order_items);
    
    $this->shipment->set_tracking_number($session->shipment->tracking_number);
    $this->shipment->set_order_collected($session->shipment->order_collected);
    $this->shipment->address->set_street_name($session->shipment->address->street_name);
    $this->shipment->address->set_street_number($session->shipment->address->street_number);
    $this->shipment->address->set_postal_code($session->shipment->address->postal_code);
    $this->shipment->address->set_city($session->shipment->address->city);
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
