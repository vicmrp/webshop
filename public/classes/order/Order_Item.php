<?php
namespace vezit\classes\order;

class Order_Item
{
  public $product_name;
  public $product_id;
  public $price;
  public $quantity;

  public function __construct($product_name, $product_id, $price, $quantity) {
    $this->product_name = $product_name;
    $this->product_id = $product_id;
    $this->price = $price;
    $this->quantity = $quantity;
  }
}
