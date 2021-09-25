<?php
namespace vezit\classes\order\order_status;

class Order_Item implements \JsonSerializable {

  private $product_name;
  private $product_id;
  private $price;
  private $quantity;

  public function __construct($product_name, $product_id, $price, $quantity) {
    $this->product_name = $product_name;
    $this->product_id = $product_id;
    $this->price = $price;
    $this->quantity = $quantity;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
