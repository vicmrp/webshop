<?php
namespace vezit\classes\session\order\order_status;
require __DIR__.'/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\classes\session\order\order_status\payment as Payment;
use vezit\classes\session\order\order_status\email as Email;


class Order_Status implements \JsonSerializable {

  public $payment;
  public $email;

  public function __construct() {
    $this->email = new Email\Email();
    $this->payment = new Payment\Payment();
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
