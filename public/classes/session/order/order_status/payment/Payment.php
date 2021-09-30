<?php
namespace vezit\classes\session\order\order_status\payment;

class Payment implements \JsonSerializable {
  private $accepted;
  private $currency;
  private $amount;

  public function __construct() {

  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
