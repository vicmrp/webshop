<?php
namespace vezit\classes\session\order;
require_once __DIR__.'/../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session\order\order_status as Order_Status;


class Order implements \JsonSerializable {

  private $order_id;
  public $order_status;
  private $order_item = array();
  
  public function __construct() {

    $this->order_id = rand(1000000,9999999);
    $this->order_status = new Order_Status\Order_Status();
  }

  public function set_order_id($order_id)
  {
    $this->order_id = $order_id;
  }

  public function get_order_id()
  {
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

  public function set_order_item(object $order_item)
  {
    // skubber et objekt ind i arrayen af typen Order_Item
    array_push($this->order_item, $order_item);
  }

  public function get_order_item()
  {
    return $this->order_item;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
