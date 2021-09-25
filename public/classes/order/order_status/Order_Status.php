<?php
namespace vezit\classes\order\order_status;

class Order_Status
{
  public $payment;
  public $email;

  public function __construct($payment, $email) {
    $this->payment = $payment;
    $this->email = $email;
  }
}
