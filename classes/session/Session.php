<?php namespace vezit\classes\session;
require __DIR__.'/../../global-requirements.php';

use vezit\classes\session\customer\Customer;
use vezit\classes\session\order\Order;
use vezit\classes\session\order\order_item\Order_Item;
use vezit\classes\session\shipment\Shipment;
use vezit\dto\session\response\Session_Response;

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

  public function __construct() {

    $this->customer = new Customer();
    $this->order = new Order();
    $this->shipment = new Shipment();


    // Check if session already exist
    if (isset($_SESSION["active_session_response"]) === true) {
      $active_session_response = json_decode($_SESSION["active_session_response"]);
      $this->construct_session_from_repository($active_session_response);
    } else {
      $this->session_id = $this->new_session_id();
      $this->order->set_order_id($this->session_id);
    }
  }









  public function set_storing_session_response() : void
  {
    $session_response = new Session_Response();
    $session_response->session = $this;
    $json_active_session_response = json_encode($session_response, JSON_PRETTY_PRINT);

    $_SESSION["active_session_response"] = $json_active_session_response;
  }









  private function session_id_is_unique(string $session_id) : bool
  {
    $array_of_session_ids = _scandir(_from_top_folder().'/temp_database/session');
    foreach($array_of_session_ids as $file_session_id)
    {
      if ($session_id == substr($file_session_id, 0, -5)) return false;
    }
    return true;
  }






  public function new_session_id() : string
  {
    while (true)
    {
      if ($this->session_id_is_unique($new_session_id = strval(rand(1000000, 9999999))))
      {
        return $new_session_id;
      }
    }
  }










  public function set_session_id($session_id) : void {
    $this->session_id = $session_id;
  }









  public function get_session_id() : string {
    return $this->session_id;
  }









  public function construct_session_from_repository(object $active_session_response) : void
  {
    $this->session_id = $active_session_response->session->session_id;
    $this->customer->set_customer_details_satisfied($active_session_response->session->customer->customer_details_satisfied);
    $this->customer->set_fullname($active_session_response->session->customer->fullname);
    $this->customer->contact->set_phone($active_session_response->session->customer->contact->phone);
    $this->customer->contact->set_email($active_session_response->session->customer->contact->email);
    $this->customer->address->set_street($active_session_response->session->customer->address->street);
    $this->customer->address->set_postal_code($active_session_response->session->customer->address->postal_code);
    $this->customer->address->set_city($active_session_response->session->customer->address->city);
    $this->customer->company->set_cvr_number($active_session_response->session->customer->company->cvr_number);
    $this->customer->company->set_company_name($active_session_response->session->customer->company->company_name);

    $this->order->set_order_id($active_session_response->session->order->order_id);
    $this->order->order_status->payment->set_accepted($active_session_response->session->order->order_status->payment->accepted);
    $this->order->order_status->payment->set_amount($active_session_response->session->order->order_status->payment->amount);
    $this->order->order_status->payment->set_payment_details_satisfied($active_session_response->session->order->order_status->payment->payment_details_satisfied);
    $this->order->order_status->payment->set_payment_quickpay_id($active_session_response->session->order->order_status->payment->payment_quickpay_id);
    $this->order->order_status->email->set_confirmation_sent($active_session_response->session->order->order_status->email->confirmation_sent);
    $this->order->order_status->email->set_invoice_sent($active_session_response->session->order->order_status->email->invoice_sent);
    foreach ((array)$active_session_response->session->order->order_items as $order_item) {
      $this->order->add_order_item(new Order_Item($order_item->product_name, $order_item->product_id, $order_item->price, $order_item->quantity));
    }

    $this->shipment->set_tracking_number($active_session_response->session->shipment->tracking_number);
    $this->shipment->set_order_collected($active_session_response->session->shipment->order_collected);
    $this->shipment->set_shipment_details_satisfied(true);
    $this->shipment->address->set_street_name($active_session_response->session->shipment->address->street_name);
    $this->shipment->address->set_street_number($active_session_response->session->shipment->address->street_number);
    $this->shipment->address->set_postal_code($active_session_response->session->shipment->address->postal_code);
    $this->shipment->address->set_city($active_session_response->session->shipment->address->city);
  }










  public function jsonSerialize() {
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
