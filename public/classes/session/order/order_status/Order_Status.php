<?php
namespace vezit\classes\order\order_status;

class Order_Status implements \JsonSerializable {

  private $payment;
  private $email;

  public function __construct($payment, $email) {
    $this->payment = $payment;
    $this->email = $email;
  }

  public function set_payment($payment)
  {
    $this->payment = $payment;
  }
  
  public function get_payment()
  {
    return $this->payment;
  }

  public function set_email($email)
  {
    $this->email = $email;
  }

  public function get_email()
  {
    return $this->email;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
