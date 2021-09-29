<?php
namespace vezit\classes\order;

class Order implements \JsonSerializable {

  private $order_id;
  private $order_status;
  private $order_item;
  
  public function __construct($order_id, $order_status, $order_item) {
    $this->order_id = $order_id;
    $this->order_status = $order_status;
    $this->order_item = $order_item;
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

  public function set_order_item($order_item)
  {
    $this->order_item = $order_item;
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
