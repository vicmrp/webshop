<?php
namespace vezit\classes\session\order\order_status;

class Payment implements \JsonSerializable {
  private $accepted;
  private $currency;
  private $amount;

  public function __construct($accepted, $currency, $amount) {
    $this->accepted = $accepted;
    $this->currency = $currency;
    $this->amount = $amount;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
