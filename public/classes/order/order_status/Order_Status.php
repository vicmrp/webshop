<?php
namespace vezit\classes\order\order_status;

class Order_Status implements \JsonSerializable {

  private $payment;
  private $email;

  public function __construct($payment, $email) {
    $this->payment = $payment;
    $this->email = $email;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
