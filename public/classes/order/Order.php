<?php
namespace vezit\classes\order;

class Order implements \JsonSerializable {

  private $order_id;
  private $order_status;
  private $order_item;
  
  public function __construct($order_id, $order_status, array $order_item) {
    $this->order_id = $order_id;
    $this->order_status = $order_status;
    $this->order_item = $order_item;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
