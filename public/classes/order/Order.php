<?php
namespace vezit\classes\order;

class Order
{
  public $order_id;
  public $order_status;
  public $order_items;
  
  public function __construct($order_id, $order_status, $order_items) {
    $this->order_id = $order_id;
    $this->order_status = $order_status;
    $this->order_items = $order_items;
  }
}
