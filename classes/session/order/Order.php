<?php
namespace vezit\classes\session\order;
require_once __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session\order\order_status as Order_Status;
use vezit\dto\order_item\response as Order_Item_Response;

class Order implements \JsonSerializable {

  private $order_id;
  public  $order_status;
  private $order_items = array(); // skal indenholde objekter af typen Order_Items
  
  public function __construct() {
    $this->order_status = new Order_Status\Order_Status();

    // if (isset($_SESSION["active_session_response"]) === true) {
    //   $active_session_response = json_decode($_SESSION["active_session_response"]);
    //   $this->construct_order_from_repository($active_session_response);
    // }
  }

  public function construct_order_from_repository(object $active_session_response) {
    $this->set_order_id = $active_session_response->session->order->order_id;
    // die(var_dump($active_session_response->session->order->order_items));

    // $order_items = $active_session_response->session->order->order_items;
    // foreach ($order_items as $order_item) {
    //   $order_item->product_name = $order_item->product_name . "fiisk";
    //   $new_order_item = new Order_Item\Order_Item($order_item->product_name, $order_item->product_id, $order_item->price, $order_item->quantity);
    //   $this->add_order_item($new_order_item);
    // }
    // var_dump($order_items[0]);
    // die($this->order_items[0]->get_product_name());
    // $this->order_items = $active_session_response->session->order->order_items;
  }

  public function set_order_id($order_id) {
    $this->order_id = $order_id;
  }

  public function get_order_id() {
    return $this->order_id;
  }

  public function set_order_status($order_status)
  {
    $this->order_status = $order_status;
  }

  public function get_order_status()
  {
    return $this->order_status;
  }

  public function add_order_item(Order_Item\Order_Item $order_item) : void {
    array_push($this->order_items, $order_item);
    // var_dump($order_item);
    $this->order_status->payment->set_accumulated_amount($this->order_items);
  }

  public function set_change_quantity_order_item(int $product_id, $new_quantity) : Order_Item_Response\Order_Item_Response {
    // $order_item_response = new Order_Item_Response\Order_Item_Response();

    
    if($this->get_order_item($product_id)->order_item === null)
      return $this->get_order_item($product_id);

    for ($i=0; $i < count($this->order_items); $i++) {
      if($this->order_items[$i]->get_product_id() === $product_id)
        $this->order_items[$i]->quantity = $new_quantity;
    }
    
    return $this->get_order_item($product_id);

  }

  public function set_order_items($order_items)
  {
    $this->order_items = $order_items;
  }

  public function get_order_items()
  {
    return $this->order_items;
  }

  public function get_order_item(int $product_id) : Order_Item_Response\Order_Item_Response {
    $order_item_response = new Order_Item_Response\Order_Item_Response();
    for ($i=0; $i < count($this->order_items); $i++) {
      if($this->order_items[$i]->get_product_id() === $product_id)
        $order_item_response->order_item = $this->order_items[$i];
    }
    return $order_item_response;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
    $vars = get_object_vars($this);
    return $vars;
  }
}
