<?php
namespace vezit\classes\session\order\order_status\payment;

class Payment implements \JsonSerializable {
  private $accepted = false;
  private $currency = 'DKK';
  private $amount;

  public function __construct() {

  }


  public function set_amount($amount)
  {
    $this->amount = $amount;
  }

  public function get_accumulated_amount()
  {
    return $this->amount;
  }



  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
