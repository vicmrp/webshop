<?php
namespace vezit\classes\session\order\order_item;



class Order_Item implements \JsonSerializable {

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


  public function set_product_name($product_name)
  {
    $this->product_name = $product_name;
  }

  public function get_product_name()
  {
    return $this->product_name;
  }

  public function set_product_id($product_id)
  {
    $this->product_id = $product_id;
  }

  public function get_product_id()
  {
    return $this->product_id;
  }

  public function set_price($price)
  {
    $this->price = $price;
  }

  public function get_price()
  {
    return $this->price;
  }

  public function set_quantity($quantity)
  {
    $this->quantity = $quantity;
  }

  public function get_quantity()
  {
    return $this->quantity;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
